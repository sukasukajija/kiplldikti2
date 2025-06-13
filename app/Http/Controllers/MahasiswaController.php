<?php

namespace App\Http\Controllers;

use App\Exports\MahasiswaExport;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MahasiswaTemplateExport;
use App\Exports\PencairanExport;
use App\Imports\MahasiswaImport;
use App\Imports\PencairanImport;
use App\Models\MahasiswaHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mahasiswa = Mahasiswa::all();
        return view('mahasiswa.index', compact('mahasiswa'));
    }

    /**
     * Menampilkan form tambah mahasiswa.
     */
    public function create()
    {
        return view('mahasiswa.create');
    }

    /**
     * Menyimpan mahasiswa baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|unique:mahasiswa,nik',
            'nim' => 'required|string',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:mahasiswa,email',
            'gpa' => 'nullable|numeric|min:0|max:4',
            'perguruan_tinggi_id' => 'required|exists:perguruan_tinggi,id',
            'program_studi_id' => 'required|exists:program_studi,id',
            'status_pengajuan' => 'required|in:diajukan,belumDiajukan',
            'status_mahasiswa' => 'required|in:aktif,nonaktif,cuti,lulus',
        ]);

        Mahasiswa::create($request->all());

        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Mahasiswa $mahasiswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $mahasiswa = Mahasiswa::find($request->id);
        $perguruanTinggi = \App\Models\Perguruantinggi::all();
        $programStudi = \App\Models\Programstudi::all();

        return view('layouts.digitalisasi.mahasiswa.edit', compact('mahasiswa', 'perguruanTinggi', 'programStudi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        try {
            //code...
            $request->validate([
                'nim' => "required",
                'name' => 'required|string|max:255',
                'email' => "required|email",
                'gpa' => 'nullable|numeric|min:0|max:4',
                'perguruan_tinggi_id' => 'required|exists:perguruan_tinggi,id',
                'program_studi_id' => 'required|exists:program_studi,id',
                'status_pengajuan' => 'required|in:diajukan,belumDiajukan',
                'status_mahasiswa' => 'required|in:aktif,nonaktif,cuti,lulus',
        ]);

        $mahasiswa = Mahasiswa::find($request->id);
        

        MahasiswaHistory::create([
            'mahasiswa_id' => $request->id,
            'status' => $request->status_mahasiswa,
            'alasan' => null,
            'changed_at' => now(),
        ]);


        $mahasiswa->nim = $request->nim;
        $mahasiswa->name = $request->name;
        $mahasiswa->email = $request->email;
        $mahasiswa->gpa = $request->gpa;
        $mahasiswa->perguruan_tinggi_id = $request->perguruan_tinggi_id;
        $mahasiswa->program_studi_id = $request->program_studi_id;
        $mahasiswa->status_pengajuan = $request->status_pengajuan;
        $mahasiswa->status_mahasiswa = $request->status_mahasiswa;
        
        if ($mahasiswa->save()) {
            return redirect()->back()->with('success', 'Data mahasiswa berhasil diperbarui.');
        } else {
            return redirect()->back()->with('error', 'Data mahasiswa gagal diperbarui.');
        }
    } catch (\Throwable $th) {
        return $th;
    }
    
}



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        //
    }

    public function downloadTemplate()
    {
        return Excel::download(new MahasiswaTemplateExport, 'template_import_mahasiswa.xlsx');
    }

    public function downloadFinalisasiTemplate(){
        return Excel::download(new PencairanExport, 'template_import_mahasiswa_ditetapkan.xlsx');
    }


    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);


        if($request->periode_id){

           Excel::import(new MahasiswaImport(Auth::user()->pt_id, $request->periode_id), $request->file('file'));
        } else {
           
           Excel::import(new MahasiswaImport(Auth::user()->pt_id), $request->file('file'));
        }


        return back()->with('success', 'Data berhasil diimpor!');
    }

    
    public function importFinalisasi(){

        request()->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        Excel::import(new PencairanImport, request()->file('file'));
        
        return back()->with('success', 'Data berhasil diimpor!');
    }


    public function export(Request $request){


      $request->validate([
          'mahasiswa_ids' => 'required|array',
          'mahasiswa_ids.*' => 'exists:mahasiswa,id',
      ]);


      $mahasiswa_ids = $request->mahasiswa_ids;

      Log::info($mahasiswa_ids);

      $mahasiswa = Mahasiswa::with('bank')->whereIn('id', $mahasiswa_ids)->get();

      Log::info($mahasiswa);

      return Excel::download(new MahasiswaExport($mahasiswa), 'data_mahasiswa.xlsx');
      
    }
    
}