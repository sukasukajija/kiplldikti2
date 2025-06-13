<?php

namespace Database\Seeders;

use App\Models\TipePengajuan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipePengajuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipePengajuan::create([
            'tipe' => 'Baru'
        ]);

        TipePengajuan::create([
            'tipe' => 'Ongoing'
        ]);
    }
}
