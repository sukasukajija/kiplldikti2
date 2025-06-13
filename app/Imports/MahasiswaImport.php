<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use App\Models\PendapatanPerKapita;
use App\Models\Perguruantinggi;
use App\Models\PeriodePenetapan;
use App\Models\Programstudi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class MahasiswaImport implements OnEachRow, WithHeadingRow
{
    protected $perguruanTinggiId, $periodeId;

    public function __construct($perguruanTinggiId = null, $periodeId = null)
    {
        $this->perguruanTinggiId = $perguruanTinggiId;
        $this->periodeId = $periodeId;
    }

    public function onRow(Row $row)
    {
        $data = $row->toArray();

        try {
            // --- cek mandatory minimal
            if (empty($data['nik']) 
                || empty($data['nim'])
                || empty($data['nama_siswa'])
                || empty($data['program_studi'])
                || empty($data['perguruan_tinggi'])
            ) {
                Log::info("--- cek mandatory minimal");
                return;
            }

            $ptId = $this->perguruanTinggiId;
            if (Auth::user()->role === 'superadmin') {
                $namaPT = strtolower(trim($data['perguruan_tinggi'] ?? ''));
                $pt = Perguruantinggi::where('nama_pt', 'like', '%' . $namaPT . '%')->first();
                if (! $pt) {
                    return;
                }
                $ptId = $pt->id;
            }

            // --- cari Prodi
            $namaProdi = strtolower(trim($data['program_studi']));
            $prodi = Programstudi::where('nama_prodi', 'like', '%' . $namaProdi . '%')
                     ->where('perguruan_tinggi_id', $ptId)
                     ->first();
            if (! $prodi) {
                Log::info("--- cari Prodi");
                return;
            }

            $pendapatanId = null;
            $pendapatan = 0;

            if (isset($data['penghasilan_ayah']) && $data['penghasilan_ayah'] !== '') {
                $pendapatan = $data['penghasilan_ayah'];
            } elseif (isset($data['penghasilan_ibu']) && $data['penghasilan_ibu'] !== '') {
                $pendapatan = $data['penghasilan_ibu'] > $pendapatan ? $data['penghasilan_ibu'] : $pendapatan;
            }

            if($pendapatan > 0) {
                $pendapatanPerkapitas = PendapatanPerKapita::all();

                foreach ($pendapatanPerkapitas as $pendapatanPerKapita) {
                    if ($pendapatan >= $pendapatanPerKapita->min_pendapatan && $pendapatan <= $pendapatanPerKapita->max_pendapatan) {
                        $pendapatanId = $pendapatanPerKapita->id;
                        break;
                    }
                }

                if ($pendapatanId === null) {
                    if($pendapatan < $pendapatanPerkapitas[0]->min_pendapatan) {
                        $pendapatanId = $pendapatanPerkapitas->first()->id;
                    } else {
                        $pendapatanId = $pendapatanPerkapitas->last()->id;
                    }
                }
            }
            
            $mhs = Mahasiswa::where('nik', $data['nik'])->first();
            
            if (!is_null($mhs)) {
                if(Auth::user()->role !== 'superadmin') {
                    $mhs->update([
                        'is_visible' => 1,
                        'gpa' => $data['gpa'] ?? 0,
                        'periode_id' => $this->periodeId // update periode_id jika mahasiswa sudah ada
                    ]);
                }
                Log::info("Mahasiswa Sudah Ada");
                return;
            }
            $jenisBantuanId = 1;
            if($data['skema_bantuan_pembiayaan'] && strlen($data['skema_bantuan_pembiayaan']) > 16) {
                $jenisBantuanId = 2;
            }

            $semester = $data['semester'] ?? 1;
            if(isset($data['semester']) && !is_nan($data['semester'])) {
                $semester = $data['semester'];               
            }

            // --- prepare atribut mass‐assign
            $attrs = [
                // core
                'nik'                 => $data['nik'],
                'nim'                 => $data['nim'],
                'name'                => $data['nama_siswa'],
                'email'               => $data['alamat_email'] ?? null,
                'gpa'                 => $data['gpa'] ?? null,
                'alamat'              => $data['alamat_tinggal'] ?? null,
                'tanggal_lahir'       => $data['tanggal_lahir'],
                'jenis_kelamin'       => $data['jenis_kelamin'] ?? null,
                'perguruan_tinggi_id' => $ptId,
                'program_studi_id'    => $prodi->id,
                'is_visible'          => Auth::user()->role === 'superadmin' ? 0 : 1,
                'periode_id'          => $this->periodeId, // <-- WAJIB: periode aktif saat import

                // enum default
                'status_pengajuan'    => 'belumDiajukan',
                'status_pencairan'    => 'belumDiajukan',
                'status_mahasiswa'    => 'aktif',
                'status_pddikti'      => Auth::user()->role === 'superadmin' ? 'terdata' : 'tidak_terdata',

                // tambahan field dari template:
                'status_dtks'            => $data['status_dtks'] ?? null,
                'no_pendaftaran'           => $data['no_pendaftaran'] ?? null,
                'no_kk'                    => $data['no_kartu_keluarga'] ?? null,
                'nik_kepala_keluarga'      => $data['nik_kepala_keluarga'] ?? null,
                'nisn'                     => $data['nisn'] ?? null,
                'status_p3ke'              => $data['status_p3ke'] ?? null,
                'no_kip'                   => $data['no_kip'] ?? null,
                'no_kks'                   => $data['no_kks'] ?? null,
                'asal_sekolah'             => $data['asal_sekolah'] ?? null,
                'kab_kota_sekolah'         => $data['kabkota_sekolah'] ?? null,
                'provinsi_sekolah'         => $data['provinsi_sekolah'] ?? null,
                'tempat_lahir'             => $data['tempat_lahir'] ?? null,
                'no_handphone'             => $data['no_handphone'] ?? null,
                'nama_ayah'                => $data['nama_ayah'] ?? null,
                'pekerjaan_ayah'           => $data['pekerjaan_ayah'] ?? null,
                'penghasilan_ayah'         => $data['penghasilan_ayah'] ?? null,
                'status_ayah'              => $data['status_ayah'] ?? null,
                'nama_ibu'                 => $data['nama_ibu'] ?? null,
                'pekerjaan_ibu'            => $data['pekerjaan_ibu'] ?? null,
                'penghasilan_ibu'          => $data['penghasilan_ibu'] ?? null,
                'status_ibu'               => $data['status_ibu'] ?? null,
                'jumlah_tanggungan'        => $data['jumlah_tanggungan'] ?? null,
                'kepemilikan_rumah'        => $data['kepemilikan_rumah'] ?? null,
                'tahun_perolehan'          => $data['tahun_perolehan'] ?? null,
                'sumber_listrik'           => $data['sumber_listrik'] ?? null,
                'luas_tanah'               => $data['luas_tanah'] ?? null,
                'luas_bangunan'            => $data['luas_bangunan'] ?? null,
                'sumber_air'               => $data['sumber_air'] ?? null,
                'mck'                      => $data['mck'] ?? null,
                'jarak_pusat_kota_km'      => $data['jarak_pusat_kota_km'] ?? null,
                'seleksi_penetapan'        => $data['seleksi_penetapan'] ?? null,
                'akreditasi_prodi'         => $data['akreditasi_prodi'] ?? null,
                'ukt_spp'                  => $data['uktspp'] ?? null,
                'ranking_penetapan'        => $data['ranking_penetapan'] ?? null,
                'skema_bantuan_pembiayaan' => $data['skema_bantuan_pembiayaan'] ?? null,
                'prestasi'                 => $data['prestasi'] ?? null,
                'semester'                 => $semester,
                'pendapatan_id'            => $pendapatanId,
                'jenis_bantuan_id'         => $jenisBantuanId,
            ];

            // 1) buat Mahasiswa
            $mhs = Mahasiswa::create($attrs);
        } catch (\Throwable $e) {
            Log::info('Import Mahasiswa gagal', [
                'error' => $e->getMessage(),
            ]);
        }
    }
}