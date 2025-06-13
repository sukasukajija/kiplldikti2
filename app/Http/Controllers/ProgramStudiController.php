<?php

namespace App\Http\Controllers;

use App\Models\Programstudi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProgramStudiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        if ($search) {
            $data['program_studi'] = Programstudi::where('perguruan_tinggi_id', Auth::user()->perguruantinggi->id)->where('kode_prodi', 'like', "%{$search}%")->get();
        } else {
            $data['program_studi'] = Programstudi::where('perguruan_tinggi_id', Auth::user()->perguruantinggi->id)->get();
        }
        return view('layouts.digitalisasi.program_studi.index', $data);
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('layouts.digitalisasi.program_studi.create');
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'kode_prodi' => 'required',
            'nama_prodi' => 'required',
            'akreditasi' => 'required',
        ]);
        
        $program_studi = new Programstudi();
        $program_studi->kode_prodi = $request->kode_prodi;
        $program_studi->nama_prodi = $request->nama_prodi;
        $program_studi->akreditasi = $request->akreditasi;
        $program_studi->perguruan_tinggi_id = Auth::user()->perguruantinggi->id;

        // dd($program_studi);

        if ($program_studi->save()) {
            return redirect()->route('program_studi.index')->with('message', 'Data Prodi Berhasil Disimpan.');
        } else {
            return redirect()->back()->with('error', 'Gagal Menyimpan Data Prodi.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $program_studi= Programstudi::find($id);
        return view('layouts.digitalisasi.program_studi.edit', compact('program_studi'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $program_studi = Programstudi::find($id);
        if (!$program_studi) {
            return redirect()->back()->with('error', 'Data Prodi tidak ditemukan');
        }
        $program_studi->kode_prodi = $request->kode_prodi;
        $program_studi->nama_prodi = $request->nama_prodi;
        $program_studi->akreditasi = $request->akreditasi_prodi;

        if ($program_studi->save()) {
            return redirect()->route('program_studi.index')->with('message', 'Data Prodi Berhasil Diedit.');
        } else {
            return redirect()->back()->with('error', 'Gagal Edit Data Prodi.');
        }
        return redirect()->route('program_studi.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $program_studi = Programstudi::find($id);
        // dd($program_studi);
        if (!$program_studi) {
            return redirect()->back()->with('error', 'Data Prodi tidak ditemukan');
        }

        if ($program_studi->delete()) {
            return redirect()->route('program_studi.index')->with('message', 'Data Prodi Berhasil Dihapus.');
        } else {
            return redirect()->back()->with('error', 'Gagal Menghapus Data Prodi.');
        }
        return redirect()->route('program_studi.index');
        
    }
}
