<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = [
            [
                'name' => 'Member',
                'role' => '0',
                'email' => 'danu@gmail.com',
                'password' => Hash::make('111'),
            ],
            [
                'name' => 'Admin',
                'role' => '1',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin123'),
            ],
            [
                'name' => 'Superadmin',
                'role' => '2',
                'email' => 'superadmin@gmail.com',
                'password' => Hash::make('superadmin123'),
            ],
        ];

        DB::table('users')->insert($posts);
    }
}
