<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AreasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('areas')->delete();

        \Illuminate\Support\Facades\DB::table('areas')->insert(
            [
                ['name' => 'София'],
                ['name' => 'Пловдив'],
                ['name' => 'Варна'],
                ['name' => 'Бургас'],
                ['name' => 'Русе'],
                ['name' => 'Стара Загора'],
                ['name' => 'Плевен'],
                ['name' => 'Сливен'],
                ['name' => 'Добрич'],
                ['name' => 'Шумен'],
                ['name' => 'Перник'],
                ['name' => 'Ямбол'],
                ['name' => 'Хасково'],
                ['name' => 'Пазарджик'],
                ['name' => 'Благоевград'],
                ['name' => 'Велико Търново'],
                ['name' => 'Враца'],
                ['name' => 'Габрово'],
                ['name' => 'Видин'],
                ['name' => 'Кюстендил'],
                ['name' => 'Кърджали'],
                ['name' => 'Монтана'],
                ['name' => 'Търговище'],
                ['name' => 'Ловеч'],
                ['name' => 'Силистра'],
                ['name' => 'Разград'],
                ['name' => 'Смолян'],
                ['name' => 'Софийска'],
            ]);
    }
}
