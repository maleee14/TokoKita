<?php

namespace Database\Seeders;

use Illuminate\Container\Attributes\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Saya Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123123123'),
            'foto' => '/img/user.jpg',
            'level' => 1
        ]);
    }
}
