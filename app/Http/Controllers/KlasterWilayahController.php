<?php

namespace App\Http\Controllers;

use App\Models\KlasterWilayah;
use Illuminate\Http\Request;

class KlasterWilayahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request()->has('search')) {
            $klaster = KlasterWilayah::where('nama_klaster', 'like', '%' . request('search') . '%')->get();
        }else{

            $klaster = KlasterWilayah::all();
        }
        return view('layouts.digitalisasi.klaster_wilayah.index', compact('klaster'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('layouts.digitalisasi.klaster_wilayah.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_klaster' => 'required',
            'biaya_hidup' => 'required',
        ]);

        $klaster = new KlasterWilayah();
        $klaster->nama_klaster = $request->nama_klaster;
        $klaster->biaya_hidup = $request->biaya_hidup;
        if ($klaster->save()) {
            return redirect()->route('klaster_wilayah.index')->with('message', 'Data Berhasil Disimpan');
        }else{
            return redirect()->back()->with('error', 'Gagal Menyimpan Data');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(KlasterWilayah $klasterWilayah)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $klaster = KlasterWilayah::find($id);
        return view('layouts.digitalisasi.klaster_wilayah.edit', compact('klaster'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KlasterWilayah $klasterWilayah)
    {
        $request->validate([
            'nama_klaster' => 'required',
            'biaya_hidup' => 'required',
        ]);

        $klaster = KlasterWilayah::find($request->id);
        $klaster->nama_klaster = $request->nama_klaster;
        $klaster->biaya_hidup = $request->biaya_hidup;
        if ($klaster->save()) {
            return redirect()->route('klaster_wilayah.index')->with('message', 'Data Berhasil Diubah');
        }else{
            return redirect()->back()->with('error', 'Gagal Mengubah Data');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id )
    {
        $klaster = KlasterWilayah::find($id);
        if ($klaster->delete()) {
            return redirect()->route('klaster_wilayah.index')->with('message', 'Data Berhasil Dihapus');
        }else{
            return redirect()->back()->with('error', 'Gagal Menghapus Data');
        }
    }
}
