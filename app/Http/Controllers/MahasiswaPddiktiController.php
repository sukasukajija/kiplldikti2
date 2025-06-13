<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Perguruantinggi;
use Illuminate\Http\Request;

class MahasiswaPddiktiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perguruan_tinggi = PerguruanTinggi::all();

        $query = Mahasiswa::query()->with(['perguruantinggi', 'programstudi']);

        // Filter status_pddikti (terdata / tidak_terdata)
        if ($request->has('status_pddikti') && $request->status_pddikti != '') {
            $query->where('status_pddikti', $request->status_pddikti);
        }

        // Filter perguruan tinggi
        if ($request->has('perguruan_tinggi_id') && $request->perguruan_tinggi_id != '') {
            $query->where('perguruan_tinggi_id', $request->perguruan_tinggi_id);
        }

        // Ambil per_page dari request, default 10
        $perPage = $request->get('per_page', 10);

        // Jika pilih "Semua", tampilkan semua data tanpa paginate
        if ($perPage === 'all') {
            $mahasiswa = $query->get();
        } else {
            $mahasiswa = $query->paginate($perPage);
        }

        return view('layouts.digitalisasi.mahasiswa.mahasiswa_pddikti', compact('mahasiswa', 'perguruan_tinggi'));
    }

    /**
     * Update status PDDIKTI mahasiswa.
     */
    public function updateStatus(Request $request, $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);

        // Ubah status
        $mahasiswa->status_pddikti = $request->status_pddikti;
        $mahasiswa->save();

        return back()->with('success', 'Status berhasil diperbarui.');
    }

    // Fungsi resource lain tetap ada, bisa diisi jika dibutuhkan
    public function create() {}
    public function store(Request $request) {}
    public function show(string $id) {}
    public function edit(string $id) {}
    public function update(Request $request, string $id) {}
    public function destroy(string $id) {}
}