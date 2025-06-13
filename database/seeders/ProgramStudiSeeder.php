<?php

namespace Database\Seeders;

use App\Models\Programstudi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgramStudiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Programstudi::insert([[
            'kode_prodi' => 'TI',
            'nama_prodi' => 'Teknik Informatika',
            'akreditasi' => 'A',    
            'perguruan_tinggi_id' => 1
        ],
        [
            'kode_prodi' => 'SI',
            'nama_prodi' => 'Sistem Informasi',
            'akreditasi' => 'A',    
            'perguruan_tinggi_id' => 2
    ]]);
    }
}