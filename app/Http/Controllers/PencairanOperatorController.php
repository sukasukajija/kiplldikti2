<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Mahasiswa;
use App\Models\Pencairan;
use App\Models\Pengajuan;
use App\Models\Perguruantinggi;
use App\Models\PeriodePenetapan;
use App\Models\TipePengajuan;
use App\Models\User;
use App\Notifications\PencairanToAdminNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PencairanOperatorController extends Controller
{



   private function queryMahasiswa($periode_id) {
      
      return Mahasiswa::with(['pencairan' => 
      function ($q)  { $q->where('tipe_pencairan', 'ajukan'); }
   ],
   'bank',
   'programstudi'
   )
      ->where('periode_id', $periode_id)
      ->whereHas('pengajuan', function ($q) use ($periode_id) {
         $q->where('periode_id', $periode_id)
         ->where('status', 'disetujui');
      })
      ->whereDoesntHave('pencairan', function ($q) {
         $q->where('tipe_pengajuan_id', 1)
         ->where('tipe_pencairan', 'pembatalan');
      })
      ->where('perguruan_tinggi_id', Auth::user()->pt_id)
      ->where('status_pencairan', 'diajukan');
   }

   private function getCountMahasiswaTolak($periode_id) {
      
      return Mahasiswa::where('perguruan_tinggi_id', Auth::user()->perguruantinggi->id)
                      ->where('status_pencairan', 'diajukan')
                      ->whereHas('pencairan', function ($q) use ($periode_id) {
                         $q->whereIn('status', ['ditolak', 'dibatalkan'])
                         ->where('tipe_pencairan', 'ajukan')
                         ->where('periode_id', $periode_id);
                      })->count();
   }

   private function getCountMahasiswaDiajukan($periode_id) {
      return Mahasiswa::where('perguruan_tinggi_id', Auth::user()->perguruantinggi->id)
                      ->where('status_pencairan', 'diajukan')
                      ->whereHas('pencairan', function ($q) use ($periode_id) {
                          $q->where('status', 'disetujui')
                            ->where('tipe_pencairan', 'ajukan')
                            ->where('periode_id', $periode_id);
                      })->count();
   }
    
   public function index()
   {
      $periode = PeriodePenetapan::orderBy('tanggal_dibuka', 'asc')->get();

      return view('layouts.digitalisasi.pencairan_operator.select_periode', compact('periode'));
   }

   public function selectTipePengajuan(Request $request, $periode_id) {
      
      return view('layouts.digitalisasi.pencairan_operator.select_tipe', compact('periode_id'));
   }

   public function selectTipe(Request $request, $periode_id) {
      
      return view('layouts.digitalisasi.pencairan_operator.select_tipe_pencairan', compact('periode_id'));
   }

   public function ajukan($periode_id){

      
       $perguruanTinggiId = Auth::user()->perguruantinggi->id;

       $perguruantinggi = Perguruantinggi::where("id", Auth::user()->pt_id)->first();

       $mahasiswa = $this->queryMahasiswa($periode_id)->get();
    
       $mahasiswaCount = $this->queryMahasiswa($periode_id)->count();
       
       $operator_id = Auth::user()->id;

       
      

       $pengajuanReject = $this->getCountMahasiswaTolak($periode_id);

       $pengajuanApproved = $this->getCountMahasiswaDiajukan($periode_id);

       $periode = PeriodePenetapan::findOrFail($periode_id);

      return view('layouts.digitalisasi.pencairan_operator.baru.ajukan', compact('mahasiswa', 'mahasiswaCount', 'operator_id', 'pengajuanReject', 'pengajuanApproved', 'periode', 'perguruantinggi'));
   }


   public function ajukanStore(Request $request, $periode_id) {

      $request->validate([
         'mahasiswa_ids' => 'required|array',
         'mahasiswa_ids.*' => 'required|exists:mahasiswa,id',
      ]);


      foreach ($request->mahasiswa_ids as $mahasiswa_id) {

         $pengajuanOld = Pencairan::where('mahasiswa_id', $mahasiswa_id)
                              ->where('tipe_pencairan', 'ajukan')
                              ->where('tipe_pengajuan_id', 1)
                              ->first();

         if ($pengajuanOld) {
            $pengajuanOld->delete();
         }


         $pencairan =Pencairan::create([
           'mahasiswa_id' => $mahasiswa_id,
           'operator_id' => Auth::user()->id,
           'periode_id' => $periode_id,
           'status' => 'diajukan',
           'tipe_pencairan' => 'ajukan',
           'tipe_pengajuan_id' => 1,
         ]);

         $users = User::where('role', 'superadmin')->get();
         foreach ($users as $user) {
            $user->notify(new PencairanToAdminNotification($pencairan));
         }
      }

      return redirect()->route('pencairan.baru.ajukan', ['periode_id' => $periode_id])->with('message', 'Pengajuan berhasil dibuat.');
   }


   public function selectBank(Request $request)
   {
      if(! $request->tipe) {
         abort(404);
      }


      $tipe = $request->tipe;
      $bank = Bank::all();

      return view('layouts.digitalisasi.pencairan_operator.select_bank', compact('bank', 'tipe'));
   }

   public function uploadDokumen(Request $request)
   {
      if(! $request->bank_id || ! $request->tipe) {
         abort(404);
      }

       $tipe = $request->tipe;
       $bank_id = $request->bank_id;

      return view('layouts.digitalisasi.pencairan_operator.upload_dokumen', compact('bank_id', 'tipe'));
   }


   public function store(Request $request)
   {

      try {
         //code...
     

      $request->validate([
        'file_sk' => 'required|mimes:pdf|max:2048',
        'file_sptjm' => 'required|mimes:pdf|max:2048',
        'file_ba' => 'required|mimes:pdf|max:2048',
      ]);

      $fileBa = $request->file('file_ba')->store('dokumen_ba', 'public');
      $fileSk = $request->file('file_sk')->store('dokumen_sk', 'public');
      $fileSptjm = $request->file('file_sptjm')->store('dokumen_sptjm', 'public');

      session([
          'file_ba' => $fileBa,
          'file_sk' => $fileSk,
          'file_sptjm' => $fileSptjm,
      ]);

      // Setelah upload, redirect ke halaman pilih mahasiswa
      return redirect()->route('pencairan.create', [
          'bank_id' => $request->bank_id,
          'tipe' => $request->tipe,
      ])->with('message', 'Dokumen berhasil diupload!');

      } catch (\Throwable $th) {
         return $th;
      }
   }

   public function pencairan(Request $request)
   {

      $perguruanTinggiId = Auth::user()->perguruantinggi->id;

        $perguruantinggi = Perguruantinggi::where("id", Auth::user()->pt_id)->first();

        $mahasiswa = Mahasiswa::where('perguruan_tinggi_id', $perguruanTinggiId)->get();
    
        $mahasiswaBelumDiajukan = Mahasiswa::where('perguruan_tinggi_id', $perguruanTinggiId)
            ->whereHas('pengajuan', function ($q) {
                $q->whereHas('pencairan', function ($q) {
                    $q->where('status', 'didaftarkan');
                });
            })
            ->where('bank_id', $request->bank_id)
            ->whereHas('pengajuan.pencairan')
            ->get();

        $mahasiswaDiajukan = Mahasiswa::where('perguruan_tinggi_id', $perguruanTinggiId)
            ->whereHas('pengajuan', function ($q) {
                $q->whereHas('pencairan', function ($q) {
                    $q->where('status', 'disetujui');
                });
            })
            ->where('bank_id', $request->bank_id)
            ->whereHas('pengajuan.pencairan')
            ->get();
    
        $mahasiswaCount = Mahasiswa::where('perguruan_tinggi_id', $perguruanTinggiId)->count();


        $bank = Bank::find($request->bank_id);


         $operator_id = Auth::user()->id;

        $pengajuanReject = Pencairan::whereHas('pengajuan', function ($q) use ($operator_id) {
         $q->where('operator_id', $operator_id);
         })
         ->where('status', 'ditolak')
         ->count();

                 $pengajuanApproved = Pencairan::whereHas('pengajuan', function ($q) use ($operator_id) {
             $q->where('operator_id', $operator_id);
         })->where('status','=','disetujui')->count();

    
        $tipe = TipePengajuan::where('tipe', $request->query('tipe'))->first();
    
        if (!$tipe) {
            return redirect()->back()->with('error', 'Data tidak ditemukan!');
        }
     
        return view('layouts.digitalisasi.pencairan_operator.create', compact('perguruantinggi', 'bank','mahasiswaBelumDiajukan','mahasiswaDiajukan', 'tipe', 'mahasiswa','mahasiswaCount','pengajuanReject','pengajuanApproved'));

   }


   public function pencairanStore(Request $request) {


      DB::beginTransaction();

      $request->validate([
         'mahasiswa_ids' => 'required|array',
         'bank_id' => 'required|exists:banks,id',
         'tipe_pengajuan_id' => 'required|exists:tipe_pengajuan,id',
      ]);


      $pengajuanIds = Pengajuan::whereIn('mahasiswa_id', $request->mahasiswa_ids)->get()->pluck('id');
      
      Pencairan::whereIn('pengajuan_id', $pengajuanIds)->where('status', 'didaftarkan')->delete();

       $fileSk = session('file_sk');
       $fileSptjm = session('file_sptjm');
       $fileBa = session('file_ba');

      foreach ($pengajuanIds as $pengajuanId) {

         $pencairan = Pencairan::create([
            'pengajuan_id' => $pengajuanId,
            'status' => 'diajukan',
            'tipe_pengajuan_id' => $request->tipe_pengajuan_id,
            'file_sptjm' => $fileSptjm,
            'file_sk' => $fileSk,
            'file_ba' => $fileBa,
         ]);

         $admin = User::where('role', 'superadmin')->get();

         foreach ($admin as $item) {
                $item->notify(new PencairanToAdminNotification($pencairan));
            }
      }


      DB::commit();

      return redirect()->route('pencairan.create')->with('success', 'Pencairan berhasil disimpan!');
   }
}