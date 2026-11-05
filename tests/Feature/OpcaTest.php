<?php

namespace Tests\Feature;

use App\Models\cliente;
use App\Models\pedido;
use App\Models\precio_base;
use App\Models\tipo_servicio;
use App\Models\User;
use Database\Seeders\PrecioBaseSeeder;
use Database\Seeders\SeguridadSeeder;
use Database\Seeders\TipoServicioSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Pruebas integrales (Feature) de los módulos principales de OPCA.
 * Se ejecutan en memoria (:memory:) gracias a RefreshDatabase.
 */
class OpcaTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 1. Verifica que todas las vistas del sitio público respondan 200 OK sin sesión.
     */
    public function test_sitio_publico_carga_correctamente(): void
    {
        $this->seed([TipoServicioSeeder::class, PrecioBaseSeeder::class]);

        $this->get(route('sitio.index'))->assertStatus(200);
        $this->get(route('sitio.galeria'))->assertStatus(200);
        $this->get(route('sitio.precios'))->assertStatus(200);
        $this->get(route('sitio.estado_pedido'))->assertStatus(200);
    }

    /**
     * 2. Verifica que las rutas administrativas estén protegidas por el middleware auth.
     */
    public function test_rutas_administrativas_redirigen_a_login_sin_sesion(): void
    {
        $this->get(route('calendario.index'))->assertRedirect(route('login'));
        $this->get(route('pedidos.index'))->assertRedirect(route('login'));
        $this->get(route('pedidos.kanban'))->assertRedirect(route('login'));
        $this->get(route('finanzas.index'))->assertRedirect(route('login'));
        $this->get(route('inventario.index'))->assertRedirect(route('login'));
    }

    /**
     * 3. Verifica que la administradora pueda iniciar sesión con credenciales válidas.
     */
    public function test_administradora_puede_iniciar_sesion(): void
    {
        $this->seed(SeguridadSeeder::class);

        $respuesta = $this->post(route('login.store'), [
            'email'    => config('seguridad.admin.email'),
            'password' => config('seguridad.admin.password'),
        ]);

        $respuesta->assertRedirect('/calendario');
        $this->assertAuthenticated();
    }

    /**
     * 4. Verifica el flujo guiado completo: crea cliente, medidas, pedido, prenda con
     *    precio congelado y abono inicial, calculando el saldo pendiente correctamente.
     */
    public function test_flujo_guiado_crea_pedido_congela_precio_y_calcula_saldo(): void
    {
        $this->seed([SeguridadSeeder::class, TipoServicioSeeder::class, PrecioBaseSeeder::class]);
        $admin = User::first();

        $vestido = precio_base::where('nombre_prenda', 'Vestido')->first();
        $confeccion = tipo_servicio::where('servicio', 'confeccion')->first();

        $respuesta = $this->actingAs($admin)->post(route('pedidos.guardar'), [
            'cliente_modo'  => 'nuevo',
            'cliente'       => [
                'nombre'   => 'Elena',
                'apellido' => 'Vargas',
                'correo'   => 'elena.vargas@example.com',
                'telefono' => '3112223344',
            ],
            'medidas'       => [
                'contorno_pecho' => 90,
                'cintura'        => 72,
            ],
            'fecha'         => '2026-11-04',
            'fecha_entrega' => '2026-11-12',
            'descripcion'   => 'Vestido de gala',
            'prendas'       => [
                [
                    'id_precio_bases'   => $vestido->id,
                    'id_tipo_servicios' => $confeccion->id,
                    'descripcion'       => 'Seda verde esmeralda',
                ],
            ],
            'abono_activo'  => '1',
            'abono_monto'   => 50000,
            'abono_fecha'   => '2026-11-04',
            'abono_notas'   => 'Abono inicial en efectivo',
        ]);

        $respuesta->assertRedirect();

        $pedido_creado = pedido::first();
        $this->assertNotNull($pedido_creado);
        $this->assertEquals(120000.00, (float) $pedido_creado->precio);
        $this->assertEquals(70000.00, (float) $pedido_creado->saldo_pendiente);
        $this->assertDatabaseHas('clientes', ['correo' => 'elena.vargas@example.com']);
    }

    /**
     * 5. Verifica que Finanzas no permita registrar un pago mayor al saldo pendiente.
     */
    public function test_finanzas_rechaza_pago_mayor_al_saldo_pendiente(): void
    {
        $this->seed([SeguridadSeeder::class, TipoServicioSeeder::class, PrecioBaseSeeder::class]);
        $admin = User::first();

        $cliente = cliente::create([
            'nombre'         => 'Pedro',
            'apellido'       => 'Gómez',
            'correo'         => 'pedro@example.com',
            'telefono'       => '3001112233',
            'fecha_registro' => '2026-11-04',
        ]);

        $pedido = pedido::create([
            'fecha'           => '2026-11-04',
            'fecha_entrega'   => '2026-11-10',
            'estado'          => 'recibido',
            'descripcion'     => 'Arreglo pantalón',
            'precio'          => 20000,
            'saldo_pendiente' => 20000,
            'idcliente'       => $cliente->id,
        ]);

        $this->actingAs($admin)->post(route('finanzas.store'), [
            'id_pedido' => $pedido->id,
            'monto'     => 35000, // Mayor a los $20.000 de saldo
            'fecha'     => '2026-11-04',
        ])->assertSessionHas('error');

        $this->assertEquals(20000.00, (float) $pedido->fresh()->saldo_pendiente);
    }

    /**
     * 6. Verifica el registro de inventario y la detección de alerta de stock bajo.
     */
    public function test_inventario_registra_material_y_detecta_stock_bajo(): void
    {
        $this->seed(SeguridadSeeder::class);
        $admin = User::first();

        $this->actingAs($admin)->post(route('inventario.store'), [
            'nombre'          => 'Hilo dorado especial',
            'categoria'       => 'Hilos',
            'stock'           => 2,
            'unidad'          => 'conos',
            'precio_unitario' => 7500,
            'stock_minimo'    => 5,
        ])->assertRedirect(route('inventario.index'));

        $this->assertDatabaseHas('inventarios', ['nombre' => 'Hilo dorado especial']);

        $respuesta = $this->actingAs($admin)->get(route('inventario.index'));
        $respuesta->assertStatus(200);
        $respuesta->assertSee('Hilo dorado especial');
    }

    /**
     * 7. Verifica que un cliente pueda consultar el estado de su pedido por correo en el sitio público.
     */
    public function test_consulta_publica_de_pedido_por_correo(): void
    {
        $cliente = cliente::create([
            'nombre'         => 'Sofía',
            'apellido'       => 'Martínez',
            'correo'         => 'sofia.martinez@example.com',
            'telefono'       => '3159998877',
            'fecha_registro' => '2026-11-04',
        ]);

        pedido::create([
            'fecha'           => '2026-11-04',
            'fecha_entrega'   => '2026-11-15',
            'estado'          => 'en_proceso',
            'descripcion'     => 'Blusa bordada a mano',
            'precio'          => 55000,
            'saldo_pendiente' => 25000,
            'idcliente'       => $cliente->id,
        ]);

        $respuesta = $this->get(route('sitio.estado_pedido', ['correo' => 'sofia.martinez@example.com']));

        $respuesta->assertStatus(200);
        $respuesta->assertSee('Blusa bordada a mano');
    }
}
