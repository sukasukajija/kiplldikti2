<?php

namespace Database\Seeders;

use App\Models\PendapatanPerKapita;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PendapatanPerKapitaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

         $data = [
            [
                'keterangan' => 'Fakir Miskin',
                'min_pendapatan' => null,
                'max_pendapatan' => 800_000
            ],
            [
                'keterangan' => 'Miskin',
                'min_pendapatan' => 800_000,
                'max_pendapatan' => 1_200_000
            ],
            [
                'keterangan' => 'Rentan Miskin',
                'min_pendapatan' => 1_200_00,
                'max_pendapatan' => 1_800_000
            ],
            [
                'keterangan' => 'Menengah Bawah',
                'min_pendapatan' => 1_800_000,
                'max_pendapatan' => 2_500_000
            ],
            [
                'keterangan' => 'Menengah',
                'min_pendapatan' => 2_500_000,
                'max_pendapatan' => 3_500_000
            ],
            [
                'keterangan' => 'Menengah Atas',
                'min_pendapatan' => 3_500_000,
                'max_pendapatan' => 4_800_000
            ],
            [
                'keterangan' => 'Mapan',
                'min_pendapatan' => 4_800_000,
                'max_pendapatan' => 6_500_000
            ],
            [
               'keterangan' => 'Kaya',
               'min_pendapatan' => 6_500_000,
               'max_pendapatan' => 10_000_000
            ],
            [
               'keterangan' => 'Sangat Kaya',
               'min_pendapatan' => 10_000_000,
               'max_pendapatan' => 20_000_000
            ],
            [
               'keterangan' => 'Super Kaya',
               'min_pendapatan' => 20_000_000,
               'max_pendapatan' => null
            ]

         ];

        PendapatanPerKapita::insert($data);
    }
}  