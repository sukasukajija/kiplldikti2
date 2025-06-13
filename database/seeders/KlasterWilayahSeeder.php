<?php

namespace Database\Seeders;

use App\Models\KlasterWilayah;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KlasterWilayahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KlasterWilayah::create([
            'nama_klaster' => 'Klaster 1',
            'biaya_hidup' => '3700000'
        ]);

    }
}
