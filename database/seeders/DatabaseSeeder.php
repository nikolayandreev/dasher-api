<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(AreasTableSeeder::class);
        $this->call(UsersTableSeeder::class);

        /* Testing only */
        $this->call(VendorsTableSeeder::class);
        $this->call(ClientsTableSeeder::class);
        $this->call(EmployeesTableSeeder::class);

        $this->call(PlansTableSeeder::class);
        // \App\Models\User::factory(10)->create();
    }
}
