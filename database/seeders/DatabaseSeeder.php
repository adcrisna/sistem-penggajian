<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       DB::table('users')->insert([
            'name'	=> 'Admin',
            'email'	=> 'admin@gmail.com',
            'password'	=> bcrypt('password'),
            'jk' => 'Laki-Laki',
            'no_hp' => '085172116048',
            'jabatan_id' => null,
            'role' => 'Admin',
        ]);
    }
}
