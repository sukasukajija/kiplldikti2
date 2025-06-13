<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;

class PengajuanAwal implements FromArray, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $pengajuans;

    public function __construct($pengajuans = [])
    {
        $this->pengajuans = $pengajuans;
    }

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

    public function array(): array {
        $rows = [];

        $index = 1;

        foreach ($this->pengajuans as $pengajuan) {


            $mahasiswa = $pengajuan->mahasiswa;

            $rows[] = [
                '',
                $mahasiswa->nim ?? '-', // NIM
                str_pad($pengajuan->id, 4, '0', STR_PAD_LEFT), // No. Pengajuan
                $mahasiswa->no_pendaftaran ?? '-', // No. Pendaftaran
                $mahasiswa->name ?? '-', // Nama Siswa
                $mahasiswa->nik ?? '-', // NIK
                $mahasiswa->no_kk ?? '-', // No. Kartu Keluarga
                $mahasiswa->nik_kepala_keluarga ?? '-', // NIK Kepala Keluarga
                $mahasiswa->nisn ?? '-', // NISN
                $mahasiswa->gpa ?? '-', // GPA
                $mahasiswa->status_dtks ?? '-', // Status DTKS
                $mahasiswa->status_p3ke ?? '-', // Status P3KE
                $mahasiswa->no_kip ?? '-', // No. KIP
                $mahasiswa->no_kks ?? '-', // No. KKS
                $mahasiswa->asal_sekolah ?? '-', // Asal Sekolah
                $mahasiswa->kab_kota_sekolah ?? '-', // Kab/Kota Sekolah
                $mahasiswa->provinsi_sekolah ?? '-', // Provinsi Sekolah
                $mahasiswa->tempat_lahir ?? '-', // Tempat Lahir
                $mahasiswa->tanggal_lahir ?? '-', // Tanggal Lahir
                $mahasiswa->jenis_kelamin ?? '-', // Jenis Kelamin
                $mahasiswa->alamat ?? '-', // Alamat Tinggal
                $mahasiswa->no_handphone ?? '-', // No. Handphone
                $mahasiswa->email ?? '-', // Alamat Email
                $mahasiswa->nama_ayah ?? '-', // Nama Ayah
                $mahasiswa->pekerjaan_ayah ?? '-', // Pekerjaan Ayah
                $mahasiswa->penghasilan_ayah ?? '-', // Penghasilan Ayah
                $mahasiswa->status_ayah ?? '-', // Status Ayah
                $mahasiswa->nama_ibu ?? '-', // Nama Ibu
                $mahasiswa->pekerjaan_ibu ?? '-', // Pekerjaan Ibu
                $mahasiswa->penghasilan_ibu ?? '-', // Penghasilan Ibu
                $mahasiswa->status_ibu ?? '-', // Status Ibu
                $mahasiswa->jumlah_tanggungan ?? '-', // Jumlah Tanggungan
                $mahasiswa->kepemilikan_rumah ?? '-', // Kepemilikan Rumah
                $mahasiswa->tahun_perolehan ?? '-', // Tahun Perolehan
                $mahasiswa->sumber_listrik ?? '-', // Sumber Listrik
                $mahasiswa->luas_tanah ?? '-', // Luas Tanah
                $mahasiswa->luas_bangunan ?? '-', // Luas Bangunan
                $mahasiswa->sumber_air ?? '-', // Sumber Air
                $mahasiswa->mck ?? '-', // MCK
                $mahasiswa->jarak_pusat_kota_km ?? '-', // Jarak Pusat Kota (KM)
                $mahasiswa->seleksi_penetapan ?? '-', // Seleksi Penetapan
                $mahasiswa->perguruanTinggi?->nama_pt ?? '-', // Perguruan Tinggi
                $mahasiswa->programstudi?->nama_prodi ?? '-', // Program Studi
                $mahasiswa->programstudi?->akreditasi ?? '-', // Akreditasi Prodi
                $mahasiswa->ukt_spp ?? '-', // UKT/SPP
                $index, // Ranking Penetapan
                $mahasiswa->semester ?? '-', // Semester
                $mahasiswa->kategori_penetapan ?? '-', // Kategori Penetapan
                $mahasiswa->skema_bantuan_pembiayaan ?? '-', // Skema Bantuan Pembiayaan
                $mahasiswa->prestasi ?? '-', // Prestasi
            ];

            $index++;
        }
        return $rows;
    }
}