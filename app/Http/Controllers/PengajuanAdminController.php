<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\Perguruantinggi;
use App\Models\PeriodePenetapan;
use App\Models\PeriodePenetapanPerguruanTinggi;
use App\Notifications\PengajuanDiprosesNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanAdminController extends Controller
{
    /**
     * Menampilkan daftar pengajuan.
     */
    public function index(Request $request)
    {
        // Ambil daftar perguruan tinggi untuk filter
        $perguruan_tinggi = Perguruantinggi::all();
        
        // Ambil daftar periode penerimaan untuk filter
        $periode = PeriodePenetapan::all();

        // Ambil data pengajuan dengan filter
        $query = Pengajuan::query()->with(['mahasiswa.perguruantinggi', 'mahasiswa.programstudi', 'periode', 'tipePengajuan']);

        // Filter berdasarkan Perguruan Tinggi
        if ($request->has('perguruan_tinggi_id') && $request->perguruan_tinggi_id != '') {
            $query->whereHas('mahasiswa.perguruantinggi', function ($q) use ($request) {
                $q->where('id', $request->perguruan_tinggi_id);
            });
        }

        // Filter berdasarkan Periode Penerimaan
        if ($request->has('periode_id') && $request->periode_id != '') {
            $query->where('periode_id', $request->periode_id);
        }

        // Filter berdasarkan pencarian NIK mahasiswa
        if ($request->has('search') && $request->search != '') {
            $query->whereHas('mahasiswa', function ($q) use ($request) {
                $q->where('nim', 'like', '%' . $request->search . '%');
            });
        }

        // Ambil per_page dari request, default 10
        $perPage = $request->get('per_page', 10);

        // Jika pilih "Semua", tampilkan semua data tanpa paginate
        if ($perPage === 'all') {
            $pengajuan = $query->get();
        } else {
            $pengajuan = $query->paginate($perPage);
        }

        return view('layouts.digitalisasi.pengajuan_admin.index', compact('pengajuan', 'perguruan_tinggi', 'periode'));
    }

    /**
     * Menampilkan detail pengajuan.
     */
    public function show($id, Request $request)
{
    $perguruantinggi = Perguruantinggi::where("id", Auth::user()->pt_id)->first();
    $pengajuan = Pengajuan::with(['mahasiswa.perguruantinggi', 'periode', 'tipePengajuan'])->findOrFail($id);

    $file = PeriodePenetapanPerguruanTinggi::where('periode_penetapan_id', $pengajuan->periode_id)
        ->where('perguruan_tinggi_id', $pengajuan->mahasiswa->perguruan_tinggi_id)
        ->first();

    // Ambil parameter query untuk tombol aksi
    $queryParams = $request->only(['page', 'per_page', 'perguruan_tinggi_id', 'periode_id', 'search']);

    return view('layouts.digitalisasi.pengajuan_admin.detail', compact('pengajuan','perguruantinggi', 'file', 'queryParams'));
}

    /**
     * Menyetujui pengajuan.
     */
    public function approve($id, Request $request)
    {
        $pengajuan = Pengajuan::findOrFail($id);
        $pengajuan->update(['status' => 'disetujui', 'remarks' => null]);
        
        $operator = $pengajuan->operator;
        $operator->notify(new PengajuanDiprosesNotification($pengajuan));

        // Redirect dengan parameter page agar tetap di halaman saat ini
        $redirectParams = $request->only(['page', 'per_page', 'perguruan_tinggi_id', 'periode_id', 'search']);
        
        return redirect()->route('pengajuan_admin.index', $redirectParams)->with('message', 'Pengajuan telah disetujui.');
    }

    /**
     * Menolak pengajuan (tampilkan form).
     */
    public function reject($id, Request $request)
{
    $pengajuan = Pengajuan::with(['mahasiswa.perguruantinggi', 'periode', 'tipePengajuan'])->findOrFail($id);

    // Ambil parameter query untuk dibawa ke form
    $queryParams = $request->only(['page', 'per_page', 'perguruan_tinggi_id', 'periode_id', 'search']);

    return view('layouts.digitalisasi.pengajuan_admin.reject', compact('pengajuan', 'queryParams'));
}

    /**
     * Proses penolakan pengajuan.
     */
    public function rejectPost(Request $request, $id)
{
    $request->validate([
        'remarks' => 'required',
    ]);

    $pengajuan = Pengajuan::findOrFail($id);
    $pengajuan->update(['status' => 'ditolak', 'remarks' => $request->remarks]);
    
    $operator = $pengajuan->operator;
    $operator->notify(new PengajuanDiprosesNotification($pengajuan));
    
    // Redirect dengan parameter page agar tetap di halaman saat ini
    $redirectParams = $request->only(['page', 'per_page', 'perguruan_tinggi_id', 'periode_id', 'search']);
    
    return redirect()->route('pengajuan_admin.index', $redirectParams)->with('message', 'Pengajuan telah ditolak.');
}

    /**
     * Menampilkan daftar pengajuan yang sudah disetujui.
     */
    public function approvedList(Request $request)
    {
        // Ambil daftar perguruan tinggi untuk filter
        $perguruan_tinggi = Perguruantinggi::all();

        // Query untuk mengambil mahasiswa dengan status pengajuan disetujui
        $query = Pengajuan::with(['mahasiswa.perguruantinggi', 'mahasiswa.programstudi', 'periode', 'tipePengajuan'])
            ->where('status', 'disetujui'); // Hanya yang statusnya "disetujui"

        // Filter berdasarkan Perguruan Tinggi
        if ($request->has('perguruan_tinggi_id') && $request->perguruan_tinggi_id != '') {
            $query->whereHas('mahasiswa.perguruantinggi', function ($q) use ($request) {
                $q->where('id', $request->perguruan_tinggi_id);
            });
        }

        // Filter berdasarkan Periode Penerimaan
        if ($request->has('periode_id') && $request->periode_id != '') {
            $query->where('periode_id', $request->periode_id);
        }

        // Filter berdasarkan pencarian NIK mahasiswa
        if ($request->has('search') && $request->search != '') {
            $query->whereHas('mahasiswa', function ($q) use ($request) {
                $q->where('nim', 'like', '%' . $request->search . '%');
            });
        }

        // Ambil per_page dari request, default 10
        $perPage = $request->get('per_page', 10);

        // Jika pilih "Semua", tampilkan semua data tanpa paginate
        if ($perPage === 'all') {
            $pengajuan = $query->get();
        } else {
            $pengajuan = $query->paginate($perPage);
        }

        return view('layouts.digitalisasi.pengajuan_admin.approved_list', compact('pengajuan', 'perguruan_tinggi'));
    }
}