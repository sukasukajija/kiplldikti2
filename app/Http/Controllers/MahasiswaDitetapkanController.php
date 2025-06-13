<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\Perguruantinggi;
use App\Models\PeriodePenetapan;
use App\Models\Programstudi;
use Illuminate\Support\Facades\Auth;

class MahasiswaDitetapkanController extends Controller
{
    public function adminDitetapkan(Request $request)
    {
        // Ambil daftar perguruan tinggi untuk filter
        $perguruan_tinggi = Perguruantinggi::all();

        // Query mahasiswa dengan status "disetujui"
        $query = Pengajuan::with(['mahasiswa.perguruantinggi', 'periode', 'tipePengajuan'])
            ->where('status', 'disetujui');

        // Filter berdasarkan Perguruan Tinggi
        if ($request->perguruan_tinggi_id) {
            $query->whereHas('mahasiswa.perguruantinggi', function ($q) use ($request) {
                $q->where('id', $request->perguruan_tinggi_id);
            });
        }

        // Filter berdasarkan pencarian NIK mahasiswa
        if ($request->search) {
            $query->whereHas('mahasiswa', function ($q) use ($request) {
                $q->where('nim', 'like', '%' . $request->search . '%');
            });
        }

        // Ambil hasil query
        $pengajuan = $query->get();

        return view('layouts.digitalisasi.mahasiswa_ditetapkan.admin_index', compact('pengajuan', 'perguruan_tinggi'));
    }

    public function operatorDitetapkan(Request $request)
{
    $periode = PeriodePenetapan::all();
    $program_studi = Programstudi::all();

    $query = Pengajuan::with(['mahasiswa.programstudi', 'mahasiswa.perguruantinggi'])
        ->where('status', 'disetujui')
        ->where('operator_id', Auth::user()->id);

    // Filter Periode
    if ($request->filled('periode')) {
        $query->where('periode_id', $request->periode);
    }

    // Filter Program Studi
    if ($request->filled('program_studi')) {
        $query->whereHas('mahasiswa.programstudi', function ($q) use ($request) {
            $q->where('id', $request->program_studi);
        });
    }

    // Pencarian NIM
    if ($request->filled('search')) {
        $query->whereHas('mahasiswa', function ($q) use ($request) {
            $q->where('nim', 'like', '%' . $request->search . '%');
        });
    }

    $pengajuan = $query->get();

    return view('layouts.digitalisasi.mahasiswa_ditetapkan.opt_index', compact('pengajuan', 'periode', 'program_studi'));
}

}
