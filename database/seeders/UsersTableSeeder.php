<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('users')->delete();

        \Illuminate\Support\Facades\DB::table('admins')
                                      ->insert([
                                          [
                                              'first_name' => 'Николай',
                                              'last_name'  => 'Андреев',
                                              'email'      => 'admin@bookie.bg',
                                              'password'   => \Illuminate\Support\Facades\Hash::make('secret'),
                                          ],
                                      ]);

        \Illuminate\Support\Facades\DB::table('users')
                                      ->insert([
                                          [
                                              'first_name' => 'Таня',
                                              'last_name'  => 'Георгиева',
                                              'email'      => 'owner@bookie.bg',
                                              'password'   => \Illuminate\Support\Facades\Hash::make('secret'),
                                              'type' => User::TYPE_OWNER,
                                          ],
                                          [
                                              'first_name' => 'Мартин',
                                              'last_name'  => 'Вълчев',
                                              'email'      => 'employee@bookie.bg',
                                              'password'   => \Illuminate\Support\Facades\Hash::make('secret'),
                                              'type' => User::TYPE_EMPLOYEE,
                                          ],
                                      ]);

        User::where('email', 'owner@bookie.bg')->first()->assignRole('manager');
        User::where('email', 'employee@bookie.bg')->first()->assignRole('employee-elevated');
    }
}
