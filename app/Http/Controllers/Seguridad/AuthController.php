<?php

namespace App\Http\Controllers\Seguridad;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Seguridad\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService) {}

    public function showLoginForm(): View
    {
        return view('seguridad.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credenciales = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $autenticado = $this->authService->autenticar(
            $credenciales['email'],
            $credenciales['password'],
            $request->boolean('remember')
        );

        if (! $autenticado) {
            return back()
                ->withErrors(['email' => 'Las credenciales no coinciden con nuestros registros.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(config('seguridad.redirect_despues_login'));
    }

    public function logout(Request $request): RedirectResponse
    {
        $this->authService->cerrarSesion();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Al cerrar sesión se vuelve al sitio público
        return redirect()->route('sitio.index');
    }

    /**
     * Muestra el formulario para solicitar el enlace de recuperación por correo.
     */
    public function mostrar_solicitud_recuperacion(): View
    {
        return view('seguridad.olvide_contrasena');
    }

    /**
     * Envía el enlace de recuperación al correo electrónico registrado.
     */
    public function enviar_enlace_recuperacion(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Por favor ingresa tu correo electrónico.',
            'email.email'    => 'Ingresa un formato de correo electrónico válido.',
        ]);

        $estado = Password::sendResetLink($request->only('email'));

        if ($estado === Password::RESET_LINK_SENT) {
            return back()->with('status', 'Hemos enviado un enlace de recuperación a tu correo electrónico.');
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'No encontramos una cuenta registrada con ese correo electrónico.']);
    }

    /**
     * Muestra el formulario para definir la nueva contraseña a partir del token enviado al correo.
     */
    public function mostrar_formulario_restablecer(Request $request, string $token): View
    {
        return view('seguridad.restablecer_contrasena', [
            'token' => $token,
            'email' => $request->query('email', ''),
        ]);
    }

    /**
     * Valida el token y actualiza la contraseña del usuario en la base de datos.
     */
    public function restablecer_contrasena(Request $request): RedirectResponse
    {
        $request->validate([
            'token'    => ['required'],
            'email'    => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'password.min'       => 'La nueva contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
        ]);

        $estado = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $usuario, string $password) {
                $usuario->forceFill([
                    'password'       => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        if ($estado === Password::PASSWORD_RESET) {
            return redirect()->route('login')
                ->with('status', 'Tu contraseña ha sido restablecida correctamente. Ya puedes iniciar sesión.');
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'El enlace de recuperación es inválido o ha expirado. Solicita uno nuevo.']);
    }
}
