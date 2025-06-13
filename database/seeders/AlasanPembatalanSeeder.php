<?php

namespace Database\Seeders;

use App\Models\AlasanPembatalan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AlasanPembatalanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sebabPembatalan = [
            ['keterangan' => 'Meninggal dunia', 'status' => 'nonaktif'],
            ['keterangan' => 'Putus kuliah/tidak melanjutkan pendidikan', 'status' => 'nonaktif'],
            ['keterangan' => 'Pindah ke Perguruan Tinggi lain', 'status' => 'nonaktif'],
            ['keterangan' => 'Melaksanakan cuti akademik selain karena alasan sakit atau melaksanakan cuti akademik karena alasan sakit melebihi 2 (dua) semester', 'status' => 'cuti'],
            ['keterangan' => 'Menolak menerima PIP Pendidikan Tinggi', 'status' => 'nonaktif'],
            ['keterangan' => 'Dipidana penjara berdasarkan putusan pengadilan yang telah berkekuatan hukum tetap', 'status' => 'nonaktif'],
            ['keterangan' => 'Terbukti melakukan kegiatan yang bertentangan dengan Pancasila dan Undang-Undang Dasar Negara Republik Indonesia Tahun 1945', 'status' => 'nonaktif'],
            ['keterangan' => 'Tidak memenuhi persyaratan prestasi akademik minimum', 'status' => 'nonaktif'],
            ['keterangan' => 'Tidak lagi sebagai prioritas sasaran atau tidak memenuhi persyaratan sebagai penerima PIP Pendidikan Tinggi', 'status' => 'nonaktif'],
        ];

        AlasanPembatalan::insert($sebabPembatalan);
    }
}