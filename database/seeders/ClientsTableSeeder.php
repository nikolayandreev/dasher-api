<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 100) as $index) {
            DB::table('clients')->insert([
                'vendor_id'  => $faker->numberBetween(1, 2),
                'first_name' => $faker->firstName,
                'last_name'  => $faker->lastName,
                'phone'      => $faker->e164PhoneNumber,
                'sex'        => $faker->numberBetween(1, 2),
                'created_at' => $faker->dateTimeThisMonth(),
                'updated_at' => $faker->dateTimeThisMonth(),
            ]);
        }
    }
}
