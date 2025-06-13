<?php

namespace App\Http\Controllers;

use App\Helpers\GetIdPeriodeBefore;
use App\Models\Bank;
use App\Models\EvalMahasiswa;
use App\Models\Mahasiswa;
use App\Models\PendapatanPerKapita;
use App\Models\Programstudi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EvaluasiOperatorController extends Controller
{

   public function uploadBa($periode_id){
      return view('layouts.digitalisasi.evaluasi_operator.upload_ba', compact('periode_id'));
   }


   public function uploadBaPost(Request $request, $periode_id){
      $request->validate([
         'file_ba' => 'required|mimes:pdf|max:2048',
      ]);

      $file_ba = $request->file('file_ba')->store('dokumen_ba', 'public');

      session([
         'file_ba' => $file_ba,
      ]);

      return redirect()->route('evaluasi.index', ['periode_id' => $periode_id])->with('message', 'Dokumen berhasil diupload!');
   }

    public function index($periode_id)
    {


      $program_studi = Programstudi::all();

      $periodeIds = GetIdPeriodeBefore::get($periode_id);

      
      $mahasiswa = Mahasiswa::with(['bank', 'evaluasi' => 
                           function($q) use ($periode_id) {
                              $q->where('periode_id', $periode_id);
                           }])
                           ->whereHas('pencairan', function($q) use ($periodeIds) {
                              $q->whereIn('periode_id', $periodeIds)
                              ->whereIn('tipe_pencairan', ['ajukan', 'penetapan_kembali'])
                              ->where('status', 'disetujui');
                           })
                           ->whereDoesntHave('pencairan', function($q) use ($periodeIds) {
                              $q->whereIn('periode_id', $periodeIds)
                              ->where('alasan_pembatalan_id', '!=', 4)
                              ->where('status', 'disetujui');
                           })
                           ->whereDoesntHave('pencairan', function($q) use ($periodeIds) {
                              $q->whereIn('periode_id', $periodeIds)
                              ->where('tipe_pencairan', 'kelulusan')
                              ->where('status', 'disetujui');
                           })
                           ->where('perguruan_tinggi_id', Auth::user()->pt_id);


      if(isset($_GET['program_studi']) && $_GET['program_studi'] != null) {
        $mahasiswa = $mahasiswa->where('program_studi_id', $_GET['program_studi']);
      }

      if(isset($_GET['nim']) && $_GET['nim'] != null) {
        $mahasiswa = $mahasiswa->where('nim', 'like', '%' . $_GET['nim'] . '%');
      }


      $mahasiswa = $mahasiswa->paginate(10);


      return view('layouts.digitalisasi.evaluasi_operator.index', compact('mahasiswa', 'program_studi', 'periode_id'));
    }


    public function create($periode_id, $mahasiswa_id)
    {

        $mahasiswa = Mahasiswa::with(['bank', 'evaluasi'])
        ->where('perguruan_tinggi_id', Auth::user()->pt_id)
        ->where('id', $mahasiswa_id)->where('status_pencairan', 'diajukan')->first();


        if(is_null($mahasiswa)) {
            return redirect()->route('evaluasi.index', ['periode_id' => $periode_id])->with('error', 'Data Mahasiswa tidak ditemukan.');
        }

        $pendapatan = PendapatanPerKapita::all();
        $programStudi = Programstudi::all();
        $bank = Bank::all();
        
        return view('layouts.digitalisasi.evaluasi_operator.add', compact('mahasiswa', 'bank', 'programStudi', 'pendapatan', 'periode_id'));
    }

    
    public function store(Request $request, $periode_id, $mahasiswa_id)
    {

      try {
         //code...
         
         DB::beginTransaction();
         $request->validate([
            'semester' => 'required|numeric',
            'gpa' => 'required|numeric',
            'bank_id' => 'required|string|exists:banks,id',
            'nama_rekening' => 'required|string',
            'no_rekening' => 'required|string',
            'file_transkrip' => 'required|mimes:pdf',
            'pendapatan_id' => 'required|string|exists:pendapatan_per_kapitas,id',
         ]);

         $mahasiswa = Mahasiswa::where('id', $mahasiswa_id)->first();

         if(is_null($mahasiswa)) {
            return redirect()->route('evaluasi.index', ['periode_id' => $periode_id])->with('error', 'Data Mahasiswa tidak ditemukan.');
         }

         $path = $request->file('file_transkrip')->store('file_transkrip', 'public');
         
         Mahasiswa::where('id', $mahasiswa_id)->update([
            'gpa' => $request->gpa,
            'bank_id' => $request->bank_id,
            'nama_rekening_bank' => $request->nama_rekening,
            'no_rekening_bank' => $request->no_rekening,
            'semester' => $request->semester,
            'pendapatan_id' => $request->pendapatan_id
         ]);


         $evalMahasiswa = EvalMahasiswa::where('mahasiswa_id', $mahasiswa_id)->where('periode_id', $periode_id)->first();

         if($evalMahasiswa) {
            $evalMahasiswa->delete();
         }
         
         EvalMahasiswa::create([
            'gpa' => $request->gpa,
            'semester' => $request->semester,
            'periode_id' => $periode_id,
            'mahasiswa_id' => $mahasiswa_id,
            'file_transkrip' => $path,
            'pendapatan_id' => $request->pendapatan_id
         ]);
         DB::commit();
         
         return redirect()->route('evaluasi.index', ['periode_id' => $periode_id])->with('success', 'Data Evaluasi berhasil diinputkan.');
      } catch (\Throwable $th) {
         return $th;
      }
    }
}