<?php

namespace Database\Seeders;

use App\Models\JenisBantuan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisBantuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JenisBantuan::create([
            'name' => 'Biaya pendidikan',
        ]);

        JenisBantuan::create([
            'name' => 'Biaya hidup & biaya pendidikan',
        ]);
    }
}