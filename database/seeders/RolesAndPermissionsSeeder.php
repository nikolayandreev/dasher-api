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

        // create permissions
        Permission::create(['name' => 'view own reservations']);
        Permission::create(['name' => 'view others reservations']);
        Permission::create(['name' => 'add reservations']);
        Permission::create(['name' => 'edit reservations']);
        Permission::create(['name' => 'cancel reservations']);
        Permission::create(['name' => 'remove reservations']);
        Permission::create(['name' => 'see billing']);

        Role::create(['name' => 'employee'])->givePermissionTo('view others reservations');
        Role::create(['name' => 'employee-elevated'])->givePermissionTo(['view own reservations', 'add reservations', 'edit reservations']);
        Role::create(['name' => 'receptionist'])->givePermissionTo(Permission::all());
        Role::create(['name' => 'manager'])->givePermissionTo(Permission::all());
        Role::create(['name' => 'admin'])->givePermissionTo(Permission::all());
    }
}
