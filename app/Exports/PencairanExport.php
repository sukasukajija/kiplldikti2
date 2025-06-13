<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Str;

class PencairanExport implements FromArray, WithHeadings
{
    public function headings(): array
    {
        return [
            'PIN',
            'NIM',
            "No. Pengajuan",
            'No. Pendaftaran',
            'Nama Siswa',
            'NIK',
            'No. Kartu Keluarga',
            'NIK Kepala Keluarga',
            'NISN',
            'GPA',
            'Status DTKS',
            'Status P3KE',
            'No. KIP',
            'No. KKS',
            'Asal Sekolah',
            'Kab/Kota Sekolah',
            'Provinsi Sekolah',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'Alamat Tinggal',
            'No. Handphone',
            'Alamat Email',
            'Nama Ayah',
            'Pekerjaan Ayah',
            'Penghasilan Ayah',
            'Status Ayah',
            'Nama Ibu',
            'Pekerjaan Ibu',
            'Penghasilan Ibu',
            'Status Ibu',
            'Jumlah Tanggungan',
            'Kepemilikan Rumah',
            'Tahun Perolehan',
            'Sumber Listrik',
            'Luas Tanah',
            'Luas Bangunan',
            'Sumber Air',
            'MCK',
            'Jarak Pusat Kota (KM)',
            'Seleksi Penetapan',
            'Perguruan Tinggi',
            'Program Studi',
            'Akreditasi Prodi',
            'UKT/SPP',
            'Ranking Penetapan',
            'Semester',
            'Kategori Penetapan',
            'Skema Bantuan Pembiayaan',
            'Prestasi',
        ];
    }

    
        // Implement the method to return data as an array
   public function array(): array
   {
    $row = [
        strtoupper(Str::random(16)),    // PIN
        '12345678',                     // NIM
        '0001',                         // No. Pengajuan
        'PDTR-2024001',                 // No. Pendaftaran
        'John Doe',                     // Nama Siswa
        '1234567890123456',             // NIK
        '1234567890123456',             // No. Kartu Keluarga
        '0987654321098765',             // NIK Kepala Keluarga
        '0012345678',                   // NISN
        'Terdata',                      // GPA
        'Aktif',                        // Status DTKS
        'KIP123456',                    // No. P3KE
        'KKS123456',                    // No. KIP
        'SMA Negeri 1',                 // No. KKS
        'Kota Malang',                  // Asal Sekolah
        'Jawa Timur',                   // Kab/Kota Sekolah
        'Malang',                       // Provinsi Sekolah
        '2000-05-15',                   // Tempat Lahir
        'L',                            // Tanggal Lahir
        'Jl. Soekarno Hatta No.1',      // Jenis Kelamin
        '081234567890',                 // Alamat Tinggal
        'john.doe@example.com',         // No. Handphone
        'Budi Santoso',                 // Alamat Email
        'PNS',                          // Nama Ayah
        '7000000',                      // Pekerjaan Ayah
        'Hidup',                        // Penghasilan Ayah
        'Siti Aminah',                  // Status Ayah
        'Ibu Rumah Tangga',             // Nama Ibu
        '6500000',                      // Pekerjaan Ibu
        'Hidup',                        // Penghasilan Ibu
        '3',                            // Status Ibu
        'Milik Sendiri',                // Jumlah Tanggungan
        '2015',                         // Kepemilikan Rumah
        'PLN',                          // Tahun Perolehan
        '150',                          // Sumber Listrik
        '100',                          // Luas Tanah
        'PDAM',                         // Luas Bangunan
        'Ya',                           // Sumber Air
        '15',                           // MCK
        '2024-02-20',                   // Jarak Pusat Kota (KM)
        'Online',                       // Tanggal Ditetapkan
        'Politeknik Negeri Malang',     // Seleksi Penetapan
        'Teknik Informatika',           // Perguruan Tinggi
        'A',                            // Program Studi
        '4000000',                      // Akreditasi Prodi
        '1',                            // UKT/SPP
        1,                              // Ranking Penetapan
        'Beasiswa Prestasi',            // Semester
        'Finalis Olimpiade',            // Kategori Penetapan
    ];

    // wrap it so FromArray sees one row
    return [
        $row,
    ];
   }

}