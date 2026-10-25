<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Permisos del módulo Producto
        Permission::create(['name' => 'ver productos']);
        Permission::create(['name' => 'crear productos']);
        Permission::create(['name' => 'editar productos']);
        Permission::create(['name' => 'eliminar productos']);

        // 2. Permisos del módulo Factura
        Permission::create(['name' => 'ver mis facturas']);
        Permission::create(['name' => 'ver todas facturas']);
        Permission::create(['name' => 'crear facturas']);
        Permission::create(['name' => 'anular facturas']);

        // 3. Crear Rol: Comprador
        $roleComprador = Role::create(['name' => 'comprador']);
        $roleComprador->givePermissionTo([
            'ver productos',
            'ver mis facturas',
        ]);

        // 4. Crear Rol: Vendedor
        $roleVendedor = Role::create(['name' => 'vendedor']);
        $roleVendedor->givePermissionTo([
            'ver productos',
            'editar productos', // Solo editar/ver productos, no crear/eliminar
            'ver todas facturas',
            'crear facturas',
        ]);

        // 5. Crear Rol: Administrador
        $roleAdmin = Role::create(['name' => 'administrador']);
        $roleAdmin->givePermissionTo(Permission::all());

        // 6. Crear Usuario Administrador de Prueba
        $adminUser = User::create([
            'name' => 'Administrador',
            'email' => 'admin@admin.com',
            'password' => Hash::make('12345678'),
        ]);
        $adminUser->assignRole($roleAdmin);

        // 7. Crear Usuario Vendedor de Prueba
        $vendedorUser = User::create([
            'name' => 'Vendedor',
            'email' => 'vendedor@vendedor.com',
            'password' => Hash::make('12345678'),
        ]);
        $vendedorUser->assignRole($roleVendedor);

        // 8. Crear Usuario Comprador de Prueba
        $compradorUser = User::create([
            'name' => 'Comprador',
            'email' => 'comprador@comprador.com',
            'password' => Hash::make('12345678'),
        ]);
        $compradorUser->assignRole($roleComprador);
    }
    
}
