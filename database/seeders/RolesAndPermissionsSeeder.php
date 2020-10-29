<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        Permission::create(['name' => 'vendor.create']);
        Permission::create(['name' => 'vendor.edit']);
        Permission::create(['name' => 'vendor.renew']);
        Permission::create(['name' => 'vendor.delete']);

        Permission::create(['name' => 'reservations.view']);
        Permission::create(['name' => 'reservations.view.own']);
        Permission::create(['name' => 'reservations.view.all']);
        Permission::create(['name' => 'reservations.create']);
        Permission::create(['name' => 'reservations.edit']);
        Permission::create(['name' => 'reservations.cancel']);
        Permission::create(['name' => 'reservations.delete']);

        Permission::create(['name' => 'employees.view']);
        Permission::create(['name' => 'employees.create']);
        Permission::create(['name' => 'employees.edit']);
        Permission::create(['name' => 'employees.deactivate']);
        Permission::create(['name' => 'employees.delete']);

        Permission::create(['name' => 'employees.holidays.view']);
        Permission::create(['name' => 'employees.holidays.add']);
        Permission::create(['name' => 'employees.holidays.remove']);
        Permission::create(['name' => 'employees.holidays.edit']);

        Permission::create(['name' => 'services.view']);
        Permission::create(['name' => 'services.create']);
        Permission::create(['name' => 'services.edit']);
        Permission::create(['name' => 'services.deactivate']);
        Permission::create(['name' => 'services.delete']);
        Permission::create(['name' => 'services.categories.view']);
        Permission::create(['name' => 'services.categories.create']);
        Permission::create(['name' => 'services.categories.edit']);
        Permission::create(['name' => 'services.categories.delete']);

        Permission::create(['name' => 'clients.view']);
        Permission::create(['name' => 'clients.create']);
        Permission::create(['name' => 'clients.edit']);
        Permission::create(['name' => 'clients.deactivate']);
        Permission::create(['name' => 'clients.delete']);

        Permission::create(['name' => 'clients.segments.view']);
        Permission::create(['name' => 'clients.segments.query']);
        Permission::create(['name' => 'clients.segments.download']);
        Permission::create(['name' => 'clients.segments.notify']);

        Permission::create(['name' => 'analysis.view']);
        Permission::create(['name' => 'analysis.download']);

        Permission::create(['name' => 'billing.view']);
        Permission::create(['name' => 'billing.invoices.view']);
        Permission::create(['name' => 'billing.invoices.download']);

        /* Role - employee */
        Role::create(['name' => 'employee'])->givePermissionTo(['reservations.view', 'reservations.view.own']);

        /* Role - employee-elevated */
        Role::create(['name' => 'employee-elevated'])
            ->givePermissionTo([
                'reservations.view', 'reservations.view.own', 'reservations.view.all', 'reservations.create', 'reservations.edit', 'reservations.cancel',
                'employees.view', 'employees.holidays.view',
                'services.view', 'services.categories.view',
                'clients.view', 'clients.edit', 'clients.create',
            ]);

        /* Role - receptionist */
        Role::create(['name' => 'receptionist'])->givePermissionTo([
            'reservations.view', 'reservations.view.own', 'reservations.view.all', 'reservations.create', 'reservations.edit', 'reservations.cancel', 'reservations.delete',
            'employees.view', 'employees.holidays.view',
            'services.view', 'services.categories.view',
            'clients.view', 'clients.edit', 'clients.create',
        ]);
        Role::create(['name' => 'manager'])->givePermissionTo(Permission::all());
    }
}
