<?php

namespace Database\Seeders;

use App\Models\Perguruantinggi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PerguruanTinggiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Perguruantinggi::insert([[
            'kode_pt' => 'PTM',
            'nama_pt' => 'Politeknik Negeri Malang',
            'no_rekening_bri' => '9126321321',
            'klaster_id' => 1
        ],
        [
            'kode_pt' => 'UTI',
            'nama_pt' => 'Universitas Teknokrat Indonesia',
            'no_rekening_bri' => '123456789',
            'klaster_id' => 1
        ]]);
    }
}
