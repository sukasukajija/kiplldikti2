<?php

namespace App\Http\Controllers;

use App\Helpers\GetIdPeriodeBefore;
use App\Models\Bank;
use App\Models\JenisBantuan;
use App\Models\Mahasiswa;
use App\Models\Pencairan;
use App\Models\Perguruantinggi;
use App\Models\PeriodePenetapan;
use App\Models\User;
use App\Notifications\PencairanToAdminNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PencairanOngoingOperatorController extends Controller
{

   private function queryMahasiswa($periode_id, $bank_id, $jenis_bantuan_id) {

      $periodeIds = GetIdPeriodeBefore::get($periode_id);
      
      return Mahasiswa::with(['pencairan' => 
      function ($q) use ($periode_id)  { 
         $q->whereIn('tipe_pencairan', ['ajukan', 'penetapan_kembali'])
         ->where('periode_id', $periode_id); },
         'evaluasi' => function ($q) use ($periode_id) { $q->where('periode_id', $periode_id); },
         'bank',
         'programstudi'
      ],
   )
      ->where('perguruan_tinggi_id', Auth::user()->pt_id)
      ->where('status_pencairan', 'diajukan')
      ->where('semester', '>=', 2)
      ->where('bank_id', $bank_id)
      ->where('jenis_bantuan_id', $jenis_bantuan_id)
      ->whereHas('pencairan', 
      function ($q) use ($periodeIds) { 
         $q->whereIn('periode_id', $periodeIds)
         ->whereIn('tipe_pencairan', ['ajukan', 'penetapan_kembali'])
         ->where('status', 'disetujui');
      })
      ->whereDoesntHave('pencairan', function($q) use ($periode_id) {
         $q->where('periode_id', $periode_id)
         ->whereIn('tipe_pencairan', ['pembatalan', 'kelulusan']);
      })
      ->whereDoesntHave('pencairan', 
      function($q) use ($periodeIds) {
         $q->whereIn('periode_id', $periodeIds)
         ->where('tipe_pencairan', 'pembatalan')
         ->where('alasan_pembatalan_id', '!=', 4);
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
                      ->where('semester', '>=', 2)
                      ->where('jenis_bantuan_id', $jenis_bantuan_id)
                      ->whereHas('evaluasi', function ($q) use ($periode_id) { $q->where('periode_id', $periode_id); })
                      ->whereHas('pencairan', function ($q) use ($periode_id) {
                         $q->whereIn('status', ['ditolak', 'dibatalkan'])
                         ->where('tipe_pencairan', 'penetapan_kembali')
                         ->where('periode_id', $periode_id);
                      })->count();
   }

   private function getCountMahasiswaDiajukan($periode_id, $jenis_bantuan_id) {
      return Mahasiswa::where('perguruan_tinggi_id', Auth::user()->perguruantinggi->id)
                      ->where('status_pencairan', 'diajukan')
                      ->where('semester', '>=', 2)
                     ->where('jenis_bantuan_id', $jenis_bantuan_id)
                      ->whereHas('evaluasi', function ($q) use ($periode_id) { $q->where('periode_id', $periode_id); })
                      ->whereHas('pencairan', function ($q) use ($periode_id) {
                          $q->where('status', 'disetujui')
                            ->where('tipe_pencairan', 'penetapan_kembali')
                            ->where('periode_id', $periode_id);
                      })->count();
   }


    public function selectTipe ($periode_id) {
        return view('layouts.digitalisasi.pencairan_operator_ongoing.select_tipe_pencairan', compact('periode_id'));
    }

    public function selectBank ($periode_id) {

         $bank = Bank::all();

        return view('layouts.digitalisasi.pencairan_operator_ongoing.kembali.select_bank', compact('periode_id', 'bank'));
    }


    public function uploadDokumen($periode_id, $bank_id) {

        $jenisBantuan = JenisBantuan::all();
        $bank = Bank::find($bank_id);

        if(is_null($bank)) {
            return redirect()->route('pencairan.ongoing.penetapan-kembali', ['periode_id' => $periode_id])->with('error', 'Bank tidak ditemukan.');
        }

        return view('layouts.digitalisasi.pencairan_operator_ongoing.kembali.upload_dokumen', compact('periode_id', 'bank_id', 'jenisBantuan', 'bank'));
    }

    public function uploadDokumenPost(Request $request, $periode_id, $bank_id) {

        $request->validate([
            'file_sptjm' => 'required|mimes:pdf',
            'jenis_bantuan_id' => 'required|exists:jenis_bantuans,id',
        ]);

        $file_sptjm = $request->file('file_sptjm')->store('dokumen_sptjm', 'public');

        session([
            'file_sptjm' => $file_sptjm,
        ]);

        return redirect()->route('pencairan.ongoing.penetapan-kembali.select-mahasiswa', 
        ['periode_id' => $periode_id, 
        'bank_id' => $bank_id, 
        'jenis_bantuan_id' => $request->jenis_bantuan_id])
        ->with('message', 'Dokumen berhasil diupload!');
    }


    public function selectMahasiswa($periode_id, $bank_id, $jenis_bantuan_id) {

      
       $perguruanTinggiId = Auth::user()->perguruantinggi->id;

       $perguruantinggi = Perguruantinggi::where("id", Auth::user()->pt_id)->first();

       $mahasiswa = $this->queryMahasiswa($periode_id, $bank_id, $jenis_bantuan_id)->get();
    
       $mahasiswaCount = $this->queryMahasiswa($periode_id, $bank_id, $jenis_bantuan_id)->count();
       
       $operator_id = Auth::user()->id;

       $pengajuanReject = $this->getCountMahasiswaTolak($periode_id, $jenis_bantuan_id);

       $pengajuanApproved = $this->getCountMahasiswaDiajukan($periode_id, $jenis_bantuan_id);

       $periode = PeriodePenetapan::findOrFail($periode_id);

       $bank = Bank::findOrFail($bank_id);

       $jenis_bantuan = JenisBantuan::findOrFail($jenis_bantuan_id);

      return view('layouts.digitalisasi.pencairan_operator_ongoing.kembali.select_mahasiswa', compact('mahasiswa', 'mahasiswaCount', 'operator_id', 'pengajuanReject', 'pengajuanApproved', 'periode', 'perguruantinggi', 'periode_id', 'bank_id', 'jenis_bantuan_id', 'bank', 'jenis_bantuan'));
   }

   public function selectMahasiswaPost(Request $request,  $periode_id, $bank_id, $jenis_bantuan_id) {

      $request->validate([
         'mahasiswa_ids' => 'required|array',
         'mahasiswa_ids.*' => 'exists:mahasiswa,id',
      ]);

      session([
         'mahasiswa_ids' => $request->mahasiswa_ids,
      ]);


      return redirect()->route('pencairan.ongoing.penetapan-kembali.upload-sk', ['periode_id' => $periode_id, 'bank_id' => $bank_id, 'jenis_bantuan_id' => $jenis_bantuan_id]);

   }


   public function uploadSk($periode_id, $bank_id, $jenis_bantuan_id) {
      
      return view('layouts.digitalisasi.pencairan_operator_ongoing.kembali.upload_sk', compact('periode_id', 'bank_id', 'jenis_bantuan_id'));
   }

    public function uploadSkPost(Request $request, $periode_id, $bank_id, $jenis_bantuan_id) {


         $request->validate([
            'file_sk' => 'required',
            'no_sk' => 'required|string',
            'tanggal_sk' => 'required|date',
            'file_lampiran' => 'required',
      ]);

      
      $fileSk = $request->file('file_sk')->store('dokumen_sk', 'public');
      $fileLampiran = $request->file('file_lampiran')->store('dokumen_lampiran', 'public');

      $fileSptjm = session()->get('file_sptjm');
      $fileBa = session()->get('file_ba');
      
      $mahasiswa_ids = session()->get('mahasiswa_ids');


      foreach ($mahasiswa_ids as $mahasiswa_id) {

         $pencairanOld = Pencairan::where('mahasiswa_id', $mahasiswa_id)
         ->where('periode_id', $periode_id)
         ->whereIn('tipe_pencairan', ['ajukan', 'penetapan_kembali'])->first();

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
            'tipe_pencairan' => $pencairanOld ? $pencairanOld->tipe_pencairan : 'penetapan_kembali',
            'file_lampiran' => $fileLampiran,
            'file_sk' => $fileSk,
            'file_sptjm' => $fileSptjm ?? null,
            'file_ba' => $fileBa ?? null
         ]);

         $admins = User::where('role', 'superadmin')->get();
         foreach ($admins as $admin) {
            $admin->notify(new PencairanToAdminNotification($pencairan));
         }
      }

      session()->forget(['keterangan', 'dokumen_pendukung', 'mahasiswa_ids']);
      
      return redirect()->route('pencairan.ongoing.penetapan-kembali.select-mahasiswa', ['periode_id' => $periode_id, 'bank_id' => $bank_id, 'jenis_bantuan_id' => $jenis_bantuan_id])
      ->with('message', 'Pengajuan pencairan berhasil diajukan!');
      
   }
}