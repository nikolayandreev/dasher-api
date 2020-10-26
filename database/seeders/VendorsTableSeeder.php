<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class VendorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();


        foreach (range(1, 2) as $index) {
            DB::table('vendors')->insert([
                'owner_id'    => 1,
                'name' => $faker->company,
            ]);

            DB::table('vendor_addresses')->insert([
                'vendor_id' => $index,
                'area_id'    => $faker->numberBetween(1, 28),
                'street'     => $faker->streetName,
                'additional' => $faker->streetAddress,
            ]);
        }
    }
}
