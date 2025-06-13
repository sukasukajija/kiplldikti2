<?php

namespace App\Http\Controllers;

use App\Models\KlasterWilayah;
use Illuminate\Http\Request;
use App\Models\Perguruantinggi;
use Illuminate\Support\Facades\Auth;

class PerguruanTinggiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PerguruanTinggi::query();
        
        if ($request->has('search')) {
            $query->where('kode_pt', 'like', '%' . $request->search . '%');
        }
        
        $perguruan_tinggi = $query->paginate(8); // 8 data per halaman
        
        return view('layouts.digitalisasi.perguruan_tinggi.index', compact('perguruan_tinggi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $klasters = KlasterWilayah::all();
        return view('layouts.digitalisasi.perguruan_tinggi.create', compact('klasters'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validasi = Perguruantinggi::where('kode_pt',$request->kode_pt)->first();
        if($validasi) {
            return redirect()->back()->with('error', 'Gagal Menyimpan Data perguruan tinggi. Kode PT sudah pernah dibuat');
        }
        $perguruan_tinggi = new Perguruantinggi();
        $perguruan_tinggi->kode_pt = $request->kode_pt;
        $perguruan_tinggi->nama_pt = $request->nama_pt;
        $perguruan_tinggi->no_rekening_bri = $request->no_rekening_bri;
        $perguruan_tinggi->klaster_id = $request->klaster_id;

        if ($perguruan_tinggi->save()) {
            return redirect()->route('perguruan_tinggi.index')->with('message', 'Data perguruan tinggi Berhasil Disimpan.');
        } else {
            return redirect()->back()->with('error', 'Gagal Menyimpan Data perguruan tinggi.');
        }
    }

    /**
     * Display the specified resource.
     */
    // public function show(perguruan_tinggi $perguruan_tinggi)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $perguruan_tinggi= Perguruantinggi::find($id);
        $klasters = KlasterWilayah::all();
        return view('layouts.digitalisasi.perguruan_tinggi.edit', compact('perguruan_tinggi', 'klasters'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        // $validasi = Perguruantinggi::where('kode_pt',$request->kode_pt)->first();

        $perguruan_tinggi = Perguruantinggi::find($id);
        if (!$perguruan_tinggi) {
            return redirect()->back()->with('error', 'Data perguruan tinggi tidak ditemukan');
        }
        $perguruan_tinggi->kode_pt = $request->kode_pt;
        $perguruan_tinggi->nama_pt = $request->nama_pt;
        $perguruan_tinggi->klaster_id = $request->klaster_id;

        if ($perguruan_tinggi->save()) {
            return redirect()->route('perguruan_tinggi.index')->with('message', 'Data Perguruan Tinggi Berhasil Diedit.');
        } else {
            return redirect()->back()->with('error', 'Gagal Edit Data perguruan tinggi.');
        }
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $perguruan_tinggi = Perguruantinggi::find($id);
        if (!$perguruan_tinggi) {
            return redirect()->back()->with('error', 'Data perguruan tinggi tidak ditemukan');
        }

        // $niks = peserta::where('kode_pt', $id)->pluck('nik');
        // foreach ($niks as $nik) {
        //     Pengajuan::where('nik', $nik)->delete();
        // }
        // peserta::where('kode_pt', $id)->delete();
        // Programstudi::where('kode_pt', $id)->delete();


        // lanjutannya di sini penghapusannya
        // User::where('kode_pt', $id)->delete();

        if (Perguruantinggi::where('id', $id)->delete()) {
            return redirect()->route('perguruan_tinggi.index')->with('message', 'Data perguruan tinggi Berhasil Dihapus.');
        } else {
            return redirect()->back()->with('error', 'Gagal Menghapus Data perguruan tinggi.');
        }
        return redirect()->route('perguruan_tinggi.index');
        //
    }

    public function showDokumen(Request $request)
    {

        $perguruantinggi = Perguruantinggi::where("id", Auth::user()->pt_id)->first();
        return view('layouts.digitalisasi.perguruan_tinggi.upload_dokumen', compact('perguruantinggi'));
    }

    public function storeDokumen(Request $request)
    {
        $request->validate([
            'file_sk' => 'required|mimes:pdf|max:2048',
            'file_sptjm' => 'required|mimes:pdf|max:2048',
        ]);

        $perguruantinggi = Perguruantinggi::where("id", Auth::user()->pt_id)->first();
        $perguruantinggi->file_sk = $request->file('file_sk')->store('sk_files', 'public');
        $perguruantinggi->file_sptjm = $request->file('file_sptjm')->store('sptjm_files', 'public');

        if ($perguruantinggi->save()) {
            return redirect()->back()->with('success', 'Dokumen berhasil diupload.');
        } else {
            return redirect()->back()->with('error', 'Gagal mengupload dokumen.');
        }
    }
}