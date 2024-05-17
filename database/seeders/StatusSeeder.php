<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = [
            [
                'nama_status' => 'Sedang Diajukan'
            ],
            [
                'nama_status' => 'Ajuan sedang ditinjau'
            ],
            [
                'nama_status' => 'Ajuan diterima',
            ],
            [
                'nama_status' => 'Ajuan ditolak',
            ],
        ];

        DB::table('status')->insert($posts);
    }
}
