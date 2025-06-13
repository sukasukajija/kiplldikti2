<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaBankController extends Controller
{
    public function create($periode_id, $mahasiswa_id)
    {  


        $banks = Bank::all();
        $mahasiswa = Mahasiswa::with(['bank', 'perguruantinggi'])->where('id', $mahasiswa_id)->first();
        return view('layouts.digitalisasi.pencairan_operator.baru.edit-mahasiswa-bank', compact('mahasiswa', 'banks', 'periode_id'));
    }

    public function store(Request $request, $periode_id, $mahasiswa_id)
    {

        $request->validate([
            'bank_id' => 'required|exists:banks,id',
            'no_rekening_bank' => 'required|string',
            'nama_rekening_bank' => 'required|string',
        ]);

        $mahasiswaBank = Mahasiswa::findOrFail($mahasiswa_id);
 
        $mahasiswaBank->update([
            'bank_id' => $request->bank_id,
            'no_rekening_bank' => $request->no_rekening_bank,
            'nama_rekening_bank' => $request->nama_rekening_bank,
        ]);

        return redirect()->route('pencairan.baru.ajukan', ['periode_id' => $periode_id])->with('message', 'Data Mahasiswa Bank berhasil disimpan.');
    }
}