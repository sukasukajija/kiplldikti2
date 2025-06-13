<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AlasanPembatalanSeeder::class,
            JenisBantuanSeeder::class,
            BankSeeder::class,
            PendapatanPerKapitaSeeder::class,
            KlasterWilayahSeeder::class,
            PerguruanTinggiSeeder::class,
            UserSeeder::class,
            ProgramStudiSeeder::class,
            PeriodePenetapanSeeder::class,
            TipePengajuanSeeder::class,
        ]);
    }
}