<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('plans')->insert([
            [
                'title'      => 'Dasher START',
                'identifier' => 'start',
                'stripe_id'  => 'price_1HhWpJCqzBjRu4KGWi0uFozv',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title'      => 'Dasher PRO',
                'identifier' => 'pro',
                'stripe_id'  => 'price_1HhWr2CqzBjRu4KG5S5SQW4q',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
