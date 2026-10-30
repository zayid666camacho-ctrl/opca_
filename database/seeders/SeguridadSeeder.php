<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class SeguridadSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $guard = config('seguridad.guard');

        $permisoAdmin = Permission::firstOrCreate(
            ['name' => config('seguridad.permiso_admin'), 'guard_name' => $guard],
            ['modulo' => 'seguridad']
        );

        if ($permisoAdmin->modulo === null) {
            $permisoAdmin->update(['modulo' => 'seguridad']);
        }

        $rolAdmin = Role::firstOrCreate(
            ['name' => config('seguridad.rol_admin'), 'guard_name' => $guard],
            ['activo' => true]
        );
        $rolAdmin->update(['activo' => true]);
        $rolAdmin->syncPermissions(Permission::where('guard_name', $guard)->get());

        $modelo = config('auth.providers.users.model');
        $datos = config('seguridad.admin');

        $admin = $modelo::role($rolAdmin->name)->first() ?? $modelo::find(1);

        if ($admin) {
            $admin->update([
                'name'     => $datos['name'],
                'email'    => $datos['email'],
                'password' => Hash::make($datos['password']),
            ]);
        } else {
            $admin = $modelo::create([
                'name'     => $datos['name'],
                'email'    => $datos['email'],
                'password' => Hash::make($datos['password']),
            ]);
        }

        $admin->assignRole($rolAdmin);

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
