<?php

namespace App\Http\Controllers;

use App\Helpers\GetIdPeriodeBefore;
use App\Models\JenisBantuan;
use App\Models\Mahasiswa;
use App\Models\Pencairan;
use App\Models\Perguruantinggi;
use App\Models\PeriodePenetapan;
use App\Models\Programstudi;
use App\Models\User;
use App\Notifications\PencairanToAdminNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PencairanOngoingKelulusanController extends Controller
{


   private function queryMahasiswa($periode_id, $jenis_bantuan_id) {
      

      $periodeIds = GetIdPeriodeBefore::get($periode_id);


      return Mahasiswa::with(['pencairan' => 
      function ($q) use ($periode_id)  { 
         $q->where('tipe_pencairan', 'kelulusan')
         ->where('periode_id', $periode_id); },
         'evaluasi' => function ($q) use ($periode_id) { $q->where('periode_id', $periode_id); },
         'bank',
         'programstudi',
         ]
      )
      ->where('perguruan_tinggi_id', Auth::user()->pt_id)
      ->where('status_pencairan', 'diajukan')
      ->where('jenis_bantuan_id', $jenis_bantuan_id)
      ->whereHas('pencairan', 
      function ($q) use ($periodeIds) { 
         $q->whereIn('periode_id', $periodeIds)
         ->whereIn('tipe_pencairan', ['ajukan', 'penetapan_kembali'])
         ->where('status', 'disetujui'); 
      })
      ->whereDoesntHave('pencairan', function($q) use ($periode_id) {
         $q->where('periode_id', $periode_id)
         ->whereIn('tipe_pencairan', ['ajukan', 'penetapan_kembali', 'pembatalan']);
      })
      ->whereDoesntHave('pencairan', 
      function($q) use ($periodeIds) {
         $q->whereIn('periode_id', $periodeIds)
         ->where('tipe_pencairan', 'pembatalan')
         ->where('alasan_pembatalan_id', '!=', 4)
         ->where('status', 'disetujui');
      })
      ->whereDoesntHave('pencairan', 
      function($q) use ($periodeIds) {
         $q->whereIn('periode_id', $periodeIds)
         ->where('tipe_pencairan', 'kelulusan')
         ->where('status', 'disetujui');
      }) 
      ->whereHas('evaluasi', function ($q) use ($periode_id) { $q->where('periode_id', $periode_id); });

   }

   private function getCountMahasiswaTolak($periode_id, $jenis_bantuan_id) {
      
      return Mahasiswa::where('perguruan_tinggi_id', Auth::user()->perguruantinggi->id)
                      ->where('status_pencairan', 'diajukan')
                      ->where('jenis_bantuan_id', $jenis_bantuan_id)
                      ->whereHas('pencairan', function ($q) use ($periode_id) {
                         $q->whereIn('status', ['ditolak', 'dibatalkan'])
                           ->where('tipe_pencairan', 'kelulusan')
                            ->where('tipe_pengajuan_id', 2)
                           ->where('periode_id', $periode_id);
                      })->count();
   }

   private function getCountMahasiswaDiajukan($periode_id, $jenis_bantuan_id) {
      return Mahasiswa::where('perguruan_tinggi_id', Auth::user()->perguruantinggi->id)
                      ->where('status_pencairan', 'diajukan')
                      ->where('jenis_bantuan_id', $jenis_bantuan_id)
                      ->whereHas('pencairan', function ($q) use ($periode_id) {
                          $q->where('status', 'disetujui')
                            ->where('tipe_pencairan', 'kelulusan')
                             ->where('tipe_pengajuan_id', 2)
                            ->where('periode_id', $periode_id);
                      })->count();
   }
    
    public function selectJenisBantuan($periode_id)
    {

        $jenisBantuan = JenisBantuan::all();   
        return view('layouts.digitalisasi.pencairan_operator_ongoing.kelulusan.select_jenis_bantuan', compact('periode_id', 'jenisBantuan'));
    }


    public function selectJenisBantuanPost(Request $request, $periode_id)
    {

        $request->validate([
            'jenis_bantuan_id' => 'required|exists:jenis_bantuans,id',
        ]);

        $jenis_bantuan_id = $request->input('jenis_bantuan_id');

        return redirect()->route('pencairan.ongoing.kelulusan.select-mahasiswa', ['periode_id' => $periode_id, 'jenis_bantuan_id' => $jenis_bantuan_id]);
    }


    public function selectMahasiswa($periode_id, $jenis_bantuan_id)
    {
        $perguruanTinggiId = Auth::user()->perguruantinggi->id;

       $perguruantinggi = Perguruantinggi::where("id", Auth::user()->pt_id)->first();

       $mahasiswa = $this->queryMahasiswa($periode_id, $jenis_bantuan_id)->get();
    
       $mahasiswaCount = $this->queryMahasiswa($periode_id, $jenis_bantuan_id)->count();
       
       $operator_id = Auth::user()->id;

       $pengajuanReject = $this->getCountMahasiswaTolak($periode_id, $jenis_bantuan_id);

       $pengajuanApproved = $this->getCountMahasiswaDiajukan($periode_id, $jenis_bantuan_id);

       $periode = PeriodePenetapan::findOrFail($periode_id);

       $jenis_bantuan = JenisBantuan::findOrFail($jenis_bantuan_id);

        return view('layouts.digitalisasi.pencairan_operator_ongoing.kelulusan.select_mahasiswa', compact('periode_id', 'jenis_bantuan_id', 'mahasiswa', 'mahasiswaCount', 'operator_id', 'pengajuanReject', 'pengajuanApproved', 'periode', 'perguruantinggi', 'jenis_bantuan'));
    }

    public function selectMahasiswaPost(Request $request, $periode_id, $jenis_bantuan_id)
    {
        $request->validate([
            'mahasiswa_ids' => 'required|array',
            'mahasiswa_ids.*' => 'exists:mahasiswa,id',
        ]);


        session([
            'mahasiswa_ids' => $request->mahasiswa_ids,
        ]);

        
        return redirect()->route('pencairan.ongoing.kelulusan.upload-sk', ['periode_id' => $periode_id, 'jenis_bantuan_id' => $jenis_bantuan_id]);
    }


    public function uploadSK($periode_id, $jenis_bantuan_id)
    {
        return view('layouts.digitalisasi.pencairan_operator_ongoing.kelulusan.upload_sk', compact('periode_id', 'jenis_bantuan_id'));
    }

    public function uploadSkPost(Request $request, $periode_id, $jenis_bantuan_id) {

       $request->validate([
            'file_sk' => 'required|mimes:pdf|max:2048',
            'no_sk' => 'required|string',
            'tanggal_sk' => 'required|date',
            'file_lampiran' => 'required|mimes:pdf|max:2048',
      ]);

      $fileSk = $request->file('file_sk')->store('dokumen_sk', 'public');
      $fileLampiran = $request->file('file_lampiran')->store('dokumen_lampiran', 'public');
      
      $mahasiswa_ids = session()->get('mahasiswa_ids');
      $fileBa = session()->get('file_ba');


      foreach ($mahasiswa_ids as $mahasiswa_id) {

         $pencairanOld = Pencairan::where('mahasiswa_id', $mahasiswa_id)->where('periode_id', $periode_id)->where('tipe_pencairan', 'kelulusan')->first();

         if ($pencairanOld) {
            $pencairanOld->delete();
         }

         $pencairan = Pencairan::create([
            'mahasiswa_id' => $mahasiswa_id,
            'operator_id' => Auth::user()->id,
            'periode_id' => $periode_id,
            'status' => 'diajukan',
            'tipe_pengajuan_id' => 2,
            'no_sk' => $request->no_sk,
            'tanggal_sk' => $request->tanggal_sk,
            'tipe_pencairan' => 'kelulusan',
            'file_lampiran' => $fileLampiran,
            'file_sk' => $fileSk,
            'file_ba' => $fileBa ?? null
         ]);

         $admin = User::where('role', 'superadmin')->get();

         foreach ($admin as $item) {
                $item->notify(new PencairanToAdminNotification($pencairan));
            }
      }

      session()->forget(['keterangan', 'mahasiswa_ids']);


      return redirect()->route('pencairan.ongoing.kelulusan.select-mahasiswa', ['periode_id' => $periode_id, 'jenis_bantuan_id' => $jenis_bantuan_id])->with('message', 'Kelulusan berhasil diajukan');
   }

   public function editTanggalYudisium($periode_id, $jenis_bantuan_id, $mahasiswa_id){

      $mahasiswa = Mahasiswa::with([
         'perguruantinggi',
         'programstudi',
      ])->findOrFail($mahasiswa_id);

      $programStudi = Programstudi::all();

      return view('layouts.digitalisasi.pencairan_operator_ongoing.kelulusan.edit_tanggal_yudisium', compact('mahasiswa_id', 'periode_id', 'jenis_bantuan_id', 'mahasiswa', 'programStudi'));
   }

   public function editTanggalYudisiumPost(Request $request, $periode_id, $jenis_bantuan_id, $mahasiswa_id) {

      $request->validate([
         'tanggal_yudisium' => 'required|date',
      ]);

      $mahasiswa = Mahasiswa::findOrFail($mahasiswa_id);

      $mahasiswa->update([
         'tanggal_yudisium' => $request->tanggal_yudisium,
      ]);

      return redirect()->route('pencairan.ongoing.kelulusan.select-mahasiswa', ['periode_id' => $periode_id, 'jenis_bantuan_id' => $jenis_bantuan_id])->with('message', 'Tanggal Yudisium berhasil diubah');
   }
}