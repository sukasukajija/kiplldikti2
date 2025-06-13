<?php
namespace App\Exports;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;

class MahasiswaTemplateExport implements FromArray, WithHeadings
{
    public function headings(): array
    {
        // return ["NIM", "Nama", "Email", "GPA", "Program Studi", "Status Pengajuan", "Status Mahasiswa"];
        if(Auth::user()->role == 'superadmin'){
            return [
                'NIM',
                'No. Pendaftaran',
                'Nama Siswa',
                'NIK',
                'No. Kartu Keluarga',
                'NIK Kepala Keluarga',
                'NISN',
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
                'Tanggal Ditetapkan',
                'Seleksi Penetapan',
                'Perguruan Tinggi',
                'Program Studi',
                'Akreditasi Prodi',
                'UKT/SPP',
                'Ranking Penetapan',
                'Semester',
                'Skema Bantuan Pembiayaan',
                'Prestasi',
            ];
        } else {
            return [
                'NIM',
                'No. Pendaftaran',
                'Nama Siswa',
                'NIK',
                "GPA",
                'No. Kartu Keluarga',
                'NIK Kepala Keluarga',
                'NISN',
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
                'Tanggal Ditetapkan',
                'Seleksi Penetapan',
                'Program Studi',
                'Akreditasi Prodi',
                'UKT/SPP',
                'Ranking Penetapan',
                'Semester',
                'Skema Bantuan Pembiayaan',
                'Prestasi',
            ];
        }
    }

    public function array(): array
    {
        if (Auth::user()->role == 'superadmin') {
            return [
                [
                    '12345678',           // NIM
                    'PDTR-2024001',       // No. Pendaftaran
                    'John Doe',           // Nama Siswa
                    '1234567890123456',   // NIK
                    '1234567890123456',   // No. Kartu Keluarga
                    '0987654321098765',   // NIK Kepala Keluarga
                    '0012345678',         // NISN
                    'Terdata',            // Status DTKS
                    'Aktif',              // Status P3KE
                    'KIP123456',          // No. KIP
                    'KKS123456',          // No. KKS
                    'SMA Negeri 1',       // Asal Sekolah
                    'Kota Malang',        // Kab/Kota Sekolah
                    'Jawa Timur',         // Provinsi Sekolah
                    'Malang',             // Tempat Lahir
                    '2000-05-15',         // Tanggal Lahir
                    'L',                  // Jenis Kelamin
                    'Jl. Soekarno Hatta No.1', // Alamat Tinggal
                    '081234567890',       // No. Handphone
                    'john.doe@example.com', // Alamat Email
                    'Budi Santoso',       // Nama Ayah
                    'PNS',                // Pekerjaan Ayah
                    '7000000',            // Penghasilan Ayah
                    'Hidup',              // Status Ayah
                    'Siti Aminah',        // Nama Ibu
                    'Ibu Rumah Tangga',   // Pekerjaan Ibu
                    '6500000',            // Penghasilan Ibu
                    'Hidup',              // Status Ibu
                    '3',                  // Jumlah Tanggungan
                    'Milik Sendiri',      // Kepemilikan Rumah
                    '2015',               // Tahun Perolehan
                    'PLN',                // Sumber Listrik
                    '150',                // Luas Tanah
                    '100',                // Luas Bangunan
                    'PDAM',               // Sumber Air
                    'Ya',                 // MCK
                    '15',                 // Jarak Pusat Kota (KM)
                    '2024-02-20',         // Tanggal Ditetapkan
                    'Online',             // Seleksi Penetapan
                    'Politeknik Negeri Malang',    // Perguruan Tinggi
                    'Teknik Informatika', // Program Studi
                    'A',                  // Akreditasi Prodi
                    '4000000',            // UKT/SPP
                    '1',                  // Ranking Penetapan
                    1,              // Semester
                    'Biaya pendidikan',  // Skema Bantuan Pembiayaan
                    'Finalis Olimpiade'   // Prestasi
                ],
                [
                    '87654321','PDTR-2024002','Jane Smith','6543210987654321',
                    '6543210987654321','5678901234567890','0012345679','Terdata','Non-Aktif',
                    'KIP654321','KKS654321','SMK Negeri 2','Kota Bandung','Jawa Barat',
                    'Bandung','1999-12-31','P','Jl. Merdeka No.2','082134567891',
                    'jane.smith@example.com','Agus Salim','Wiraswasta','6000000','Hidup',
                    'Ratna Dewi','Guru','5500000','Hidup','2','Kontrak','2018','PLN',
                    '120','80','Sumur','Tidak','20','2024-02-21','Offline',
                    'Politeknik Negeri Malang','Teknik Informatika','B','3500000','2',
                    2,'Biaya hidup & biaya pendidikan','Juara 1 Lomba Catur'
                ],
            ];
        } else {
            return [
                [
                    '12345678',            // NIM
                    'PDTR-0001',           // No. Pendaftaran
                    'Alice Johnson',       // Nama Siswa
                    '1234567890123123',    // NIK
                    '3.75',                // GPA
                    '1234567890123456',    // No. Kartu Keluarga
                    '0987654321098765',    // NIK Kepala Keluarga
                    '0012345678',          // NISN
                    'Terdata',             // Status DTKS
                    'Aktif',               // Status P3KE
                    'KIP765432',           // No. KIP
                    'KKS765432',           // No. KKS
                    'SMP Negeri 2',        // Asal Sekolah
                    'Kota Semarang',       // Kab/Kota Sekolah
                    'Jawa Tengah',         // Provinsi Sekolah
                    'Semarang',            // Tempat Lahir
                    '2001-03-20',          // Tanggal Lahir
                    'P',                   // Jenis Kelamin
                    'Jl. Ahmad Yani 20',   // Alamat Tinggal
                    '082134567891',        // No. Handphone
                    'alice.j@example.com', // Alamat Email
                    'Agus Salim',          // Nama Ayah
                    'Wiraswasta',          // Pekerjaan Ayah
                    '6000000',             // Penghasilan Ayah
                    'Hidup',               // Status Ayah
                    'Ratna Dewi',          // Nama Ibu
                    'Guru',                // Pekerjaan Ibu
                    '5500000',             // Penghasilan Ibu
                    'Hidup',               // Status Ibu
                    '2',                   // Jumlah Tanggungan
                    'Kontrak',             // Kepemilikan Rumah
                    '2018',                // Tahun Perolehan
                    'PLN',                 // Sumber Listrik
                    '120',                 // Luas Tanah
                    '80',                  // Luas Bangunan
                    'Sumur',               // Sumber Air
                    'Tidak',               // MCK
                    '20',                  // Jarak Pusat Kota (KM)
                    '2024-02-21',          // Tanggal Ditetapkan
                    'Offline',             // Seleksi Penetapan
                    'Teknik Informatika',        // Program Studi
                    'B',                   // Akreditasi Prodi
                    '3500000',             // UKT/SPP
                    '1',                   // Ranking Penetapan
                    '12345678',            // NIM (lagi)
                    3,               // Semester
                    'Biaya hidup & biaya pendidikan',   // Skema Bantuan Pembiayaan
                    'Juara 1 Lomba Catur'  // Prestasi
                ],
                // ... kalau mau baris kedua
            ];
        }
    }
    
}