<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TemplateExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        return [
            [], // Data sample
            // Add more rows as needed
        ];
    }

    public function headings(): array
    {
        return [
            'Status (Aktif/Lulus/Cuti)',
            'NIK',
            'NISN',
            'NPSN',
            'Email',
            'NIM',
            'No KK',
            'Nama Mahasiswa',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'Alamat',
            'No HP',
            'No KKS',
            'Asal Sekolah',
            'Kab/Kota Sekolah',
            'Provinsi Sekolah',
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
            'Tahun Perolehan Rumah',
            'Sumber Listrik',
            'Luas Tanah',
            'Luas Bangunan',
            'Sumber Air',
            'MCK',
            'Jarak ke Pusat Kota (km)',
            'program_studi (masukkan kode prodi)',
            'Bank (BRI)',
            'no_rekening',
        ];
    }
}
