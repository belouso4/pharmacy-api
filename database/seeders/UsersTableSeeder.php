<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'name' => 'admin',
                'roles' => "admin",
                'email' => 'a@a.ru',
                'password' => bcrypt(12345678),
            ],
            [
                'id' => 2,
                'name' => 'user',
                'roles' => "",
                'email' => 'u@u.ru',
                'password' => bcrypt(12345678),
            ],
        ];
        DB::table('users')->insert($data);
    }
}
