<?php

namespace Database\Seeders;

use App\Models\PeriodePenetapan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PeriodePenetapanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PeriodePenetapan::insert([[
            'tahun' => '2024/2025',
            'semester' => 'Genap',
            'tanggal_dibuka' => '2024-01-01',
            'tanggal_ditutup' => '2024-06-29'
        ],[
            'tahun' => '2024/2025',
            'semester' => 'Ganjil',
            'tanggal_dibuka' => '2024-07-01',
            'tanggal_ditutup' => '2024-12-31'
        ]
    ]);
    }
}
