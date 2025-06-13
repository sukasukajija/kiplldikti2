<?php

namespace App\Http\Controllers;

use App\Exports\PencairanFinalisasiExport;
use App\Models\AlasanPembatalan;
use App\Models\Mahasiswa;
use App\Models\MahasiswaHistory;
use App\Models\Pencairan;
use App\Models\Perguruantinggi;
use App\Models\PeriodePenetapan;
use App\Models\PeriodePenetapanPerguruanTinggi;
use App\Notifications\PencairanNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PencairanAdminController extends Controller
{
    public function index(Request $request)
    {
        $perguruan_tinggi = Perguruantinggi::all();
        $periode = PeriodePenetapan::all();

        // Ambil parameter jumlah data per halaman dari request, default ke 10
        $perPage = $request->get('per_page', 10);

        $pencairans = Pencairan::with(['mahasiswa.bank', 'tipe_pengajuan', 'periode', 'operator', 'mahasiswa.perguruantinggi'])
            ->whereNot('status', 'didaftarkan')
            ->when($request->perguruan_tinggi_id, function ($query) use ($request) {
                $query->whereHas('mahasiswa', function ($q) use ($request) {
                    $q->where('perguruan_tinggi_id', $request->perguruan_tinggi_id);
                });
            })
            ->when($request->periode_id, function ($query) use ($request) {
                $query->where('periode_id', $request->periode_id);
            })
            ->when($request->tipe_pencairan, function ($query) use ($request) {
                if ($request->tipe_pencairan == 'baru_ajukan') {
                    $query->where('tipe_pengajuan_id', 1)->where('tipe_pencairan', 'ajukan');
                }
                if ($request->tipe_pencairan == 'baru_pembatalan') {
                    $query->where('tipe_pengajuan_id', 1)->where('tipe_pencairan', 'pembatalan');
                }
                if ($request->tipe_pencairan == 'ongoing_penetapan_kembali') {
                    $query->where('tipe_pengajuan_id', 2)->where('tipe_pencairan', 'penetapan_kembali');
                }
                if ($request->tipe_pencairan == 'ongoing_pembatalan') {
                    $query->where('tipe_pengajuan_id', 2)->where('tipe_pencairan', 'pembatalan');
                }
                if ($request->tipe_pencairan == 'ongoing_kelulusan') {
                    $query->where('tipe_pengajuan_id', 2)->where('tipe_pencairan', 'kelulusan');
                }
            })
            ->when($request->search, function ($query) use ($request) {
                $query->whereHas('mahasiswa', function ($q) use ($request) {
                    $q->where('nim', 'like', '%' . $request->search . '%');
                });
            });

        // Jika pilih "Semua", tampilkan semua data tanpa paginate
        if ($perPage === 'all') {
            $pencairans = $pencairans->get();
        } else {
            $pencairans = $pencairans->paginate($perPage);
        }

        return view('layouts.digitalisasi.pencairan_admin.index', compact('pencairans', 'perguruan_tinggi', 'periode'));
    }

    public function show($pencairan_id, Request $request)
    {
        // Ambil data pencairan beserta relasi yang diperlukan
        $pencairan = Pencairan::with([
            'alasanPembatalan',
            'mahasiswa.bank',
            'mahasiswa.perguruantinggi',
            'mahasiswa.evaluasi',
            'tipe_pengajuan',
            'periode',
            'operator'
        ])->findOrFail($pencairan_id);

        // Ambil data periode penetapan perguruan tinggi terkait
        $periodePT = PeriodePenetapanPerguruanTinggi::where('perguruan_tinggi_id', $pencairan->mahasiswa->perguruantinggi_id)
            ->where('periode_penetapan_id', $pencairan->periode_id)
            ->first();

        // Simpan semua parameter query untuk digunakan di view
        $queryParams = $request->only(['page', 'per_page', 'perguruan_tinggi_id', 'periode_id', 'tipe_pencairan', 'search']);

        // Pastikan file SK dan SPTJM terbaru tersedia
        $fileSk = $pencairan->file_sk; // Path file SK terbaru
        $fileSptjm = $pencairan->file_sptjm; // Path file SPTJM terbaru

        // Kirim data ke view
        return view('layouts.digitalisasi.pencairan_admin.detail', compact('pencairan', 'periodePT', 'queryParams', 'fileSk', 'fileSptjm'));
    }

public function approve($pencairan_id, Request $request)
{
    DB::beginTransaction();

    try {
        $pencairan = Pencairan::findOrFail($pencairan_id);

        // Logika approve berdasarkan tipe pencairan
        if ($pencairan->tipe_pengajuan_id == 2 && $pencairan->tipe_pencairan == 'pembatalan') {
            if ($pencairan->alasan_pembatalan_id) {
                $alasanP = AlasanPembatalan::where('id', $pencairan->alasan_pembatalan_id)->first();

                if ($alasanP) {
                    Mahasiswa::where('id', $pencairan->mahasiswa_id)->update(['status_mahasiswa' => $alasanP->status]);
                    MahasiswaHistory::create([
                        'mahasiswa_id' => $pencairan->mahasiswa_id,
                        'status' => $alasanP->status,
                        'alasan' => $alasanP->keterangan,
                        'changed_at' => now(),
                    ]);
                }
            }
        } else if ($pencairan->tipe_pengajuan_id == 2 && $pencairan->tipe_pencairan == 'kelulusan') {
            Mahasiswa::where('id', $pencairan->mahasiswa_id)->update(['status_mahasiswa' => 'lulus']);
            MahasiswaHistory::create([
                'mahasiswa_id' => $pencairan->mahasiswa_id,
                'status' => 'lulus',
                'alasan' => null,
                'changed_at' => now(),
            ]);
        } else if ($pencairan->tipe_pencairan == 'penetapan_kembali' || $pencairan->tipe_pencairan == 'ajukan') {
            $mahasiswa = Mahasiswa::where('id', $pencairan->mahasiswa_id)->first();
            if ($mahasiswa->status_mahasiswa != 'aktif') {
                Mahasiswa::where('id', $pencairan->mahasiswa_id)->update(['status_mahasiswa' => 'aktif']);
                MahasiswaHistory::create([
                    'mahasiswa_id' => $pencairan->mahasiswa_id,
                    'status' => 'aktif',
                    'alasan' => null,
                    'changed_at' => now(),
                ]);
            }
        }

        // Kirim notifikasi ke operator terkait
        $operator = $pencairan->operator;
        $operator->notify(new PencairanNotification($pencairan));

        // Perbarui status pencairan menjadi disetujui
        $pencairan->update(['status' => 'disetujui', 'dokumen_penolakan' => null, 'keterangan_penolakan' => null]);

        DB::commit();

        // Redirect ke halaman yang sama dengan parameter query
        $redirectParams = $request->only(['page', 'per_page', 'perguruan_tinggi_id', 'periode_id', 'tipe_pencairan', 'search']);
        return redirect()->route('pencairan_admin.index', $redirectParams)->with('success', 'Pencairan berhasil disetujui');
    } catch (\Throwable $th) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
    }
}

public function reject($pencairan_id, Request $request)
{
    $pencairan = Pencairan::with('mahasiswa.perguruantinggi')->findOrFail($pencairan_id);

    // Simpan parameter query untuk dikirim ke view
    $queryParams = $request->only(['page', 'per_page', 'perguruan_tinggi_id', 'periode_id', 'tipe_pencairan', 'search']);

    return view('layouts.digitalisasi.pencairan_admin.reject', compact('pencairan', 'queryParams'));
}

    public function rejectPost(Request $request, $pencairan_id)
{
    try {
        $request->validate([
            'keterangan' => 'required',
            'dokumen_penolakan' => 'required|mimes:pdf',
        ]);

        $pencairan = Pencairan::findOrFail($pencairan_id);

        $filaDokumenPenolakan = null;

        if ($request->hasFile('dokumen_penolakan')) {
            $filaDokumenPenolakan = $request->file('dokumen_penolakan')->store('dokumen_penolakan', 'public');
        }

        $pencairan->update([
            'status' => 'ditolak',
            'keterangan_penolakan' => $request->keterangan,
            'dokumen_penolakan' => $filaDokumenPenolakan
        ]);

        $operator = $pencairan->operator;
        $operator->notify(new PencairanNotification($pencairan));

        // Redirect ke halaman yang sama dengan parameter query
        $redirectParams = $request->only(['page', 'per_page', 'perguruan_tinggi_id', 'periode_id', 'tipe_pencairan', 'search']);
        return redirect()->route('pencairan_admin.index', $redirectParams)->with('message', 'Pencairan berhasil ditolak');
    } catch (\Throwable $th) {
        return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
    }
}

    public function export(Request $request)
    {
        try {
            $pencairans = Pencairan::with([
                'mahasiswa.evaluasi',
                'mahasiswa.bank',
                'mahasiswa.perguruantinggi',
                'mahasiswa.programstudi',
                'tipe_pengajuan',
                'operator',
                'periode',
                'mahasiswa.pendapatan',
            ])->whereIn('id', $request->pengajuans)->get();

            return Excel::download(new PencairanFinalisasiExport($pencairans), 'template_mahasiswa_ditetapkan.xlsx');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }
}