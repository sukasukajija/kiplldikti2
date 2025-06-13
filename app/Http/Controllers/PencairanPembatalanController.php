<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Pencairan;
use App\Models\Perguruantinggi;
use App\Models\PeriodePenetapan;
use App\Models\User;
use App\Notifications\PencairanToAdminNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PencairanPembatalanController extends Controller
{
    

    private function queryMahasiswa($periode_id) {
      
   return Mahasiswa::with(['pencairan' => 
      function ($q) { 
         $q->where('tipe_pencairan', 'pembatalan')
         ->where('tipe_pengajuan_id', 1);}
   ],
   'bank',
   'programstudi'
   )
      ->where('perguruan_tinggi_id', Auth::user()->pt_id)
      ->where('status_pencairan', 'diajukan')
      ->where('periode_id', $periode_id)
      ->whereHas('pengajuan', function ($q) use ($periode_id) {
         $q->where('periode_id', $periode_id)
         ->where('status', 'disetujui');
      })
      ->whereDoesntHave('pencairan', function ($q){
         $q->where('tipe_pengajuan_id', 1)
         ->where('tipe_pencairan', 'ajukan');
      });
   }

   private function getCountMahasiswaTolak($periode_id) {
      
      return Mahasiswa::where('perguruan_tinggi_id', Auth::user()->perguruantinggi->id)
                      ->where('status_pencairan', 'diajukan')
                      ->whereHas('pencairan', function ($q) use ($periode_id) {
                         $q->where('status', 'ditolak')
                           ->where('periode_id', $periode_id)
                         ->where('tipe_pencairan', 'pembatalan')
                         ->where('tipe_pengajuan_id', 1);
                      })->count();
   }

   private function getCountMahasiswaDiajukan($periode_id) {
      return Mahasiswa::where('perguruan_tinggi_id', Auth::user()->perguruantinggi->id)
                      ->where('status_pencairan', 'diajukan')
                      ->whereHas('pencairan', function ($q) use ($periode_id) {
                          $q->where('status', 'disetujui')
                         ->where('periode_id', $periode_id)
                         ->where('tipe_pencairan', 'pembatalan')
                         ->where('tipe_pengajuan_id', 1);
                      })->count();
   }
   
   public function index($periode_id)
   {

      $perguruanTinggiId = Auth::user()->perguruantinggi->id;

       $perguruantinggi = Perguruantinggi::where("id", Auth::user()->pt_id)->first();

       $mahasiswa = $this->queryMahasiswa($periode_id)->get();
    
       $mahasiswaCount = $this->queryMahasiswa($periode_id)->count();
       
       $operator_id = Auth::user()->id;

       
      

       $pengajuanReject = $this->getCountMahasiswaTolak($periode_id);

       $pengajuanApproved = $this->getCountMahasiswaDiajukan($periode_id);

       $periode = PeriodePenetapan::findOrFail($periode_id);
       return view('layouts.digitalisasi.pencairan_operator.pembatalan.ajukan-pembatalan', compact('mahasiswa', 'mahasiswaCount', 'operator_id', 'pengajuanReject', 'pengajuanApproved', 'periode', 'perguruantinggi'));
   }


   public function store(Request $request, $periode_id)
   {

         //code...
         $this->validate($request, [
         'keterangan' => 'required|string',
         'dokumen_pendukung' => 'required|mimes:pdf|max:2048',
         'mahasiswa_ids' => 'required|array',
         'mahasiswa_ids.*' => 'exists:mahasiswa,id'
      ]);

      if($request->hasFile('dokumen_pendukung')) {  
         $dokumen_pendukung = $request->file('dokumen_pendukung')->store('dokumen_pendukung', 'public');
      }
      
      session()->put(['keterangan' => $request->keterangan, 'dokumen_pendukung' => $dokumen_pendukung, 'mahasiswa_ids' => $request->mahasiswa_ids]);
      
      
      return redirect()->route('pencairan.baru.pembatalan.upload.sk', ['periode_id' => $periode_id]);
     
   }

   public function uploadSk($periode_id) {
    if(!session()->has(['keterangan', 'dokumen_pendukung', 'mahasiswa_ids'])) {
        // Redirect ke halaman select_tipe_pencairan jika session tidak ada
        return redirect()->route('pencairan.baru.select_tipe', ['periode_id' => $periode_id]);
    }
    return view('layouts.digitalisasi.pencairan_operator.pembatalan.upload-sk', compact('periode_id'));
}



   public function uploadSkStore(Request $request, $periode_id) {


         $request->validate([
            'file_sk' => 'required',
            'no_sk' => 'required|string',
            'tanggal_sk' => 'required|date',
            'file_lampiran' => 'required',
      ]);

      
      $fileSk = $request->file('file_sk')->store('dokumen_sk', 'public');
      $fileLampiran = $request->file('file_lampiran')->store('dokumen_lampiran', 'public');
      
      $mahasiswa_ids = session()->get('mahasiswa_ids');
      $keterangan = session()->get('keterangan');
      $dokumen_pendukung = session()->get('dokumen_pendukung');


      foreach ($mahasiswa_ids as $mahasiswa_id) {

         $pengajuanOld = Pencairan::where('mahasiswa_id', $mahasiswa_id)
                              ->where('tipe_pencairan', 'pembatalan')
                              ->where('tipe_pengajuan_id', 1)
                              ->first();

         if ($pengajuanOld) {
            $pengajuanOld->delete();
         }

         $pencairan =  Pencairan::create([
            'mahasiswa_id' => $mahasiswa_id,
            'operator_id' => Auth::user()->id,
            'periode_id' => $periode_id,
            'status' => 'diajukan',
            'tipe_pengajuan_id' => 1,
            'keterangan' => $keterangan,
            'no_sk' => $request->no_sk,
            'tanggal_sk' => $request->tanggal_sk,
            'tipe_pencairan' => 'pembatalan',
            'file_lampiran' => $fileLampiran,
            'file_sk' => $fileSk,
            'file_ba' => $dokumen_pendukung,
            'dokumen_pendukung' => $dokumen_pendukung,
         ]);


         $admin = User::where('role', 'superadmin')->get();

         foreach ($admin as $item) {
                $item->notify(new PencairanToAdminNotification($pencairan));
            }
      }

      session()->forget(['keterangan', 'dokumen_pendukung', 'mahasiswa_ids']);
      
      return redirect()->route('pencairan.baru.pembatalan', ['periode_id' => $periode_id])->with('message', 'Pembatalan berhasil diajukan!');
      
   }
}