<?php

namespace App\Http\Controllers;

use App\Exports\PengajuanAwal;
use App\Models\Mahasiswa;
use App\Models\MahasiswaHistory;
use App\Models\Pengajuan;
use App\Models\Perguruantinggi;
use App\Models\PeriodePenetapan;
use App\Models\PeriodePenetapanPerguruanTinggi;
use App\Models\User;
use App\Notifications\PengajuanToAdminNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PengajuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $periode = PeriodePenetapan::orderBy('tanggal_dibuka', 'asc')->get();
        session()->forget('file_ba');
        session()->forget('file_sk');
        session()->forget('file_sptjm');
        return view('layouts.digitalisasi.pengajuan_operator.periode', compact('periode'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, $periode_penetapan_id)
    {

        
         $fileBa = $request->session()->get('file_ba');
         $fileSk = $request->session()->get('file_sk');
         $fileSptjm = $request->session()->get('file_sptjm');
         

        if (!PeriodePenetapanPerguruanTinggi::where(
            'periode_penetapan_id', $periode_penetapan_id)->where('perguruan_tinggi_id', Auth::user()->pt_id)->exists() 
             && !($fileBa && $fileSk && $fileSptjm)
            ) {
            return redirect()->route('pengajuan_penetapan.upload_dokumen', $periode_penetapan_id)->with('message', 'Pengajuan sudah dilakukan!');
        }


        $periode = PeriodePenetapan::findOrFail($periode_penetapan_id);

        $perguruanTinggiId = Auth::user()->perguruantinggi->id;

        $perguruantinggi = Perguruantinggi::where("id", Auth::user()->pt_id)->first();

        $pengajuanReject = Mahasiswa::where('is_visible', 1)
               ->where('periode_id', $periode_penetapan_id)
               ->where('perguruan_tinggi_id', $perguruanTinggiId)
               ->whereHas('pengajuan', function ($q) {
                  $q->where('status','=','ditolak');
               })
               ->count();  
        $pengajuanApproved = Mahasiswa::where('is_visible', 1)
               ->where('periode_id', $periode_penetapan_id)
               ->where('perguruan_tinggi_id', $perguruanTinggiId)
               ->whereHas('pengajuan', function ($q) {
                $q->where('status','=','disetujui');
               })
               ->count();
        
        
        $mahasiswa = Mahasiswa::with(['pengajuan', 'perguruantinggi', 'programstudi'])
        ->where('is_visible', 1)
        ->where('periode_id', $periode_penetapan_id)
        ->where('perguruan_tinggi_id', $perguruanTinggiId)
        ->get();
    
        $mahasiswaCount = count($mahasiswa);
     
        return view('layouts.digitalisasi.pengajuan_operator.create', compact('perguruantinggi','periode', 'mahasiswa','mahasiswaCount','pengajuanReject','pengajuanApproved'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
   {
   
    DB::beginTransaction();

    $request->validate([
        'mahasiswa_ids' => 'required|array',
        'periode_id' => 'required|exists:periode_penetapan,id',
    ]);

    $fileBa = $request->session()->get('file_ba');
    $fileSk = $request->session()->get('file_sk');
    $fileSptjm = $request->session()->get('file_sptjm');
    
    foreach ($request->mahasiswa_ids as $mahasiswaId) {
        $mahasiswa = Mahasiswa::find($mahasiswaId);

        $pegajuan = Pengajuan::create([
            'mahasiswa_id' => $mahasiswaId,
            'operator_id' => Auth::user()->id,
            'periode_id' => $request->periode_id,
            'tipe_pengajuan_id' => 1,
            'status' => 'diajukan',
        ]);
        
        if($fileBa && $fileSk && $fileSptjm){
           PeriodePenetapanPerguruanTinggi::create([
            'perguruan_tinggi_id' => Auth::user()->pt_id,
            'periode_penetapan_id' => $request->periode_id,
            'file_ba' => $fileBa ?? null,
            'file_sk' => $fileSk ?? null,
            'file_sptjm' => $fileSptjm ?? null,
         ]);
        }

        $mahasiswa->update(['status_pengajuan' => 'diajukan']);

        $superadmin = User::where('role', 'superadmin')->get();

        foreach ($superadmin as $admin) {
            $admin->notify(new PengajuanToAdminNotification($pegajuan));
        }
    }

    DB::commit();

    // Setelah store pengajuan, bisa clear session file biar aman (opsional)
    session()->forget(['file_sk', 'file_sptjm']);
    
    return redirect()->back()->with('message', 'Pengajuan berhasil diajukan dan status mahasiswa telah diperbarui.');
   }



    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */

    public function history()
    {
        $operatorPTId = Auth::user()->pt_id;
    
        $latestHistory = MahasiswaHistory::select('mahasiswa_id', DB::raw('MAX(changed_at) as latest_changed_at'))
            ->groupBy('mahasiswa_id');
    
        $history = MahasiswaHistory::joinSub($latestHistory, 'latest_history', function ($join) {
                $join->on('mahasiswa_history.mahasiswa_id', '=', 'latest_history.mahasiswa_id')
                     ->on('mahasiswa_history.changed_at', '=', 'latest_history.latest_changed_at');
            })
            ->whereHas('mahasiswa', function ($query) use ($operatorPTId) {
                $query->where('perguruan_tinggi_id', $operatorPTId);
            })
            ->orderBy('mahasiswa_history.changed_at', 'desc')
            ->get();
    
        return view('layouts.digitalisasi.laporan.history', compact('history'));
    }
    
    public function uploadDokumenForm(Request $request)
{
    $periode_id = $request->periode_id;
    $tipe = $request->tipe;
    $periode = PeriodePenetapan::findOrFail($periode_id);
    
    return view('layouts.digitalisasi.pengajuan_operator.upload_dokumen', compact('periode', 'tipe'));
}


public function uploadDokumen(Request $request, $periode_penetapan_id) {
   

    return view('layouts.digitalisasi.pengajuan_operator.upload_dokumen', compact('periode_penetapan_id'));
}

public function uploadDokumenPost(Request $request, $periode_penetapan_id)
{
    $request->validate([
       'file_ba' => 'required|mimes:pdf',
       'file_sk' => 'required|mimes:pdf',
       'file_sptjm' => 'required|mimes:pdf',
    ]);

    $fileSk = $request->file('file_sk')->store('dokumen_sk', 'public');
    $fileSptjm = $request->file('file_sptjm')->store('dokumen_sptjm', 'public');
    $fileBa = $request->file('file_ba')->store('dokumen_ba', 'public');

    session([
        'file_ba' => $fileBa,
        'file_sk' => $fileSk,
        'file_sptjm' => $fileSptjm,
    ]);

    return redirect()->route('pengajuan_penetapan.create', ['periode_penetapan_id' => $periode_penetapan_id])->with('message', 'Dokumen berhasil diupload!');
}

 
    public function exportPengajuanAwal(Request $request) {

        $request->validate([
            'pengajuans' => 'required|array',
            'pengajuans.*' => 'exists:pengajuan,id',
        ]);

        $pengajuans = Pengajuan::with([
            'mahasiswa.perguruantinggi', 
            'mahasiswa.programstudi', 
            'tipePengajuan', 
            'operator', 
            'periode'
        ])->whereIn('id', $request->pengajuans)->get();

        return Excel::download(new PengajuanAwal($pengajuans), 'pengajuan_awal.xlsx');
        
    }


    public function getRejectedPengajuans(Request $request) {
        
        $pengajuans = Pengajuan::with([
            'mahasiswa',
            'tipePengajuan', 
            'operator', 
            'periode'
        ])->where('status', 'ditolak')->get();

        return view('layouts.digitalisasi.pengajuan_ditolak_operator.index', compact('pengajuans'));
    }



    public function getDetailRejectedPengajuan(Request $request, $id) {
        
        try {
            //code...
            $pengajuan = Pengajuan::with([
                'mahasiswa', 
                'tipePengajuan', 
                'operator', 
                'periode'
                ])->where('id', $id)->where('status', 'ditolak')->firstOrFail();
                return view('layouts.digitalisasi.pengajuan_ditolak_operator.pengajuan_ulang', compact('pengajuan'));
            } catch (\Throwable $th) {
                //throw $th;
                return redirect()->back()->with('error', 'Data tidak ditemukan!');
            }
    }


    public function pengajuanUlang(Request $request, $id) {
        
        $request->validate([
            'file_sk' => 'required|mimes:pdf|max:2048',
            'file_sptjm' => 'required|mimes:pdf|max:2048',
        ]);

        $fileSk = $request->file('file_sk')->store('dokumen_sk', 'public');
        $fileSptjm = $request->file('file_sptjm')->store('dokumen_sptjm', 'public');
        $pengajuan = Pengajuan::findOrFail($id);
        $pengajuan->file_sk = $fileSk;
        $pengajuan->file_sptjm = $fileSptjm;
        $pengajuan->status = 'diajukan';
        $pengajuan->save();
        $mahasiswa = Mahasiswa::findOrFail($pengajuan->mahasiswa_id);
        $mahasiswa->status_pengajuan = 'diajukan';
        $mahasiswa->save();


        return redirect()->route('pengajuan_ditolak')->with('message', 'Pengajuan berhasil diajukan ulang.');
    }
}  

//DRAFT

// <?php

// namespace App\Http\Controllers;

// use App\Exports\PengajuanAwal;
// use App\Models\Mahasiswa;
// use App\Models\MahasiswaHistory;
// use App\Models\Pengajuan;
// use App\Models\Perguruantinggi;
// use App\Models\PeriodePenetapan;
// use App\Models\PeriodePenetapanPerguruanTinggi;
// use App\Models\User;
// use App\Notifications\PengajuanToAdminNotification;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\DB;
// use Maatwebsite\Excel\Facades\Excel;

// class PengajuanController extends Controller
// {
//     /**
//      * Display a listing of the resource.
//      */
//     public function index()
//     {
//         $periode = PeriodePenetapan::orderBy('tanggal_dibuka', 'asc')->get();
//         session()->forget('file_ba');
//         session()->forget('file_sk');
//         session()->forget('file_sptjm');
//         return view('layouts.digitalisasi.pengajuan_operator.periode', compact('periode'));
//     }

//     /**
//      * Show the form for creating a new resource.
//      */
//     public function create(Request $request, $periode_penetapan_id)
//     {

        
//          $fileBa = $request->session()->get('file_ba');
//          $fileSk = $request->session()->get('file_sk');
//          $fileSptjm = $request->session()->get('file_sptjm');
         

//         if (!PeriodePenetapanPerguruanTinggi::where(
//             'periode_penetapan_id', $periode_penetapan_id)->where('perguruan_tinggi_id', Auth::user()->pt_id)->exists() 
//              && !($fileBa && $fileSk && $fileSptjm)
//             ) {
//             return redirect()->route('pengajuan_penetapan.upload_dokumen', $periode_penetapan_id)->with('message', 'Pengajuan sudah dilakukan!');
//         }


//         $periode = PeriodePenetapan::findOrFail($periode_penetapan_id);

//         $perguruanTinggiId = Auth::user()->perguruantinggi->id;

//         $perguruantinggi = Perguruantinggi::where("id", Auth::user()->pt_id)->first();

//         $pengajuanReject = Mahasiswa::where('is_visible', 1)
//                ->where('periode_id', $periode_penetapan_id)
//                ->where('perguruan_tinggi_id', $perguruanTinggiId)
//                ->whereHas('pengajuan', function ($q) {
//                   $q->where('status','=','ditolak');
//                })
//                ->count();  
//         $pengajuanApproved = Mahasiswa::where('is_visible', 1)
//                ->where('periode_id', $periode_penetapan_id)
//                ->where('perguruan_tinggi_id', $perguruanTinggiId)
//                ->whereHas('pengajuan', function ($q) {
//                 $q->where('status','=','disetujui');
//                })
//                ->count();
        
        
//         $mahasiswa = Mahasiswa::with(['pengajuan', 'perguruantinggi', 'programstudi'])
//         ->where('is_visible', 1)
//         ->where('perguruan_tinggi_id', $perguruanTinggiId)
//         ->where(function ($query) use ($periode_penetapan_id) {
//             $query->where('periode_id', $periode_penetapan_id)
//                 ->orWhereNull('periode_id');
//         })
//         ->get();
    
//         $mahasiswaCount = count($mahasiswa);
     
//         return view('layouts.digitalisasi.pengajuan_operator.create', compact('perguruantinggi','periode', 'mahasiswa','mahasiswaCount','pengajuanReject','pengajuanApproved'));
//     }

//     /**
//      * Store a newly created resource in storage.
//      */
//     public function store(Request $request)
//    {
   
//     DB::beginTransaction();

//     $request->validate([
//         'mahasiswa_ids' => 'required|array',
//         'periode_id' => 'required|exists:periode_penetapan,id',
//     ]);

//     $fileBa = $request->session()->get('file_ba');
//     $fileSk = $request->session()->get('file_sk');
//     $fileSptjm = $request->session()->get('file_sptjm');
    
//     foreach ($request->mahasiswa_ids as $mahasiswaId) {
//         $mahasiswa = Mahasiswa::find($mahasiswaId);

//         $pegajuan = Pengajuan::create([
//             'mahasiswa_id' => $mahasiswaId,
//             'operator_id' => Auth::user()->id,
//             'periode_id' => $request->periode_id,
//             'tipe_pengajuan_id' => 1,
//             'status' => 'diajukan',
//         ]);
        
//         if($fileBa && $fileSk && $fileSptjm){
//            PeriodePenetapanPerguruanTinggi::create([
//             'perguruan_tinggi_id' => Auth::user()->pt_id,
//             'periode_penetapan_id' => $request->periode_id,
//             'file_ba' => $fileBa ?? null,
//             'file_sk' => $fileSk ?? null,
//             'file_sptjm' => $fileSptjm ?? null,
//          ]);
//         }

//         $mahasiswa->update(['status_pengajuan' => 'diajukan']);

//         $superadmin = User::where('role', 'superadmin')->get();

//         foreach ($superadmin as $admin) {
//             $admin->notify(new PengajuanToAdminNotification($pegajuan));
//         }
//     }

//     DB::commit();

//     // Setelah store pengajuan, bisa clear session file biar aman (opsional)
//     session()->forget(['file_sk', 'file_sptjm']);
    
//     return redirect()->back()->with('message', 'Pengajuan berhasil diajukan dan status mahasiswa telah diperbarui.');
//    }



//     /**
//      * Display the specified resource.
//      */

//     /**
//      * Show the form for editing the specified resource.
//      */

//     public function history()
//     {
//         $operatorPTId = Auth::user()->pt_id;
    
//         $latestHistory = MahasiswaHistory::select('mahasiswa_id', DB::raw('MAX(changed_at) as latest_changed_at'))
//             ->groupBy('mahasiswa_id');
    
//         $history = MahasiswaHistory::joinSub($latestHistory, 'latest_history', function ($join) {
//                 $join->on('mahasiswa_history.mahasiswa_id', '=', 'latest_history.mahasiswa_id')
//                      ->on('mahasiswa_history.changed_at', '=', 'latest_history.latest_changed_at');
//             })
//             ->whereHas('mahasiswa', function ($query) use ($operatorPTId) {
//                 $query->where('perguruan_tinggi_id', $operatorPTId);
//             })
//             ->orderBy('mahasiswa_history.changed_at', 'desc')
//             ->get();
    
//         return view('layouts.digitalisasi.laporan.history', compact('history'));
//     }
    
//     public function uploadDokumenForm(Request $request)
// {
//     $periode_id = $request->periode_id;
//     $tipe = $request->tipe;
//     $periode = PeriodePenetapan::findOrFail($periode_id);
    
//     return view('layouts.digitalisasi.pengajuan_operator.upload_dokumen', compact('periode', 'tipe'));
// }


// public function uploadDokumen(Request $request, $periode_penetapan_id) {
   

//     return view('layouts.digitalisasi.pengajuan_operator.upload_dokumen', compact('periode_penetapan_id'));
// }

// public function uploadDokumenPost(Request $request, $periode_penetapan_id)
// {
//     $request->validate([
//        'file_ba' => 'required|mimes:pdf',
//        'file_sk' => 'required|mimes:pdf',
//        'file_sptjm' => 'required|mimes:pdf',
//     ]);

//     $fileSk = $request->file('file_sk')->store('dokumen_sk', 'public');
//     $fileSptjm = $request->file('file_sptjm')->store('dokumen_sptjm', 'public');
//     $fileBa = $request->file('file_ba')->store('dokumen_ba', 'public');

//     session([
//         'file_ba' => $fileBa,
//         'file_sk' => $fileSk,
//         'file_sptjm' => $fileSptjm,
//     ]);

//     return redirect()->route('pengajuan_penetapan.create', ['periode_penetapan_id' => $periode_penetapan_id])->with('message', 'Dokumen berhasil diupload!');
// }

 
//     public function exportPengajuanAwal(Request $request) {

//         $request->validate([
//             'pengajuans' => 'required|array',
//             'pengajuans.*' => 'exists:pengajuan,id',
//         ]);

//         $pengajuans = Pengajuan::with([
//             'mahasiswa.perguruantinggi', 
//             'mahasiswa.programstudi', 
//             'tipePengajuan', 
//             'operator', 
//             'periode'
//         ])->whereIn('id', $request->pengajuans)->get();

//         return Excel::download(new PengajuanAwal($pengajuans), 'pengajuan_awal.xlsx');
        
//     }


//     public function getRejectedPengajuans(Request $request) {
        
//         $pengajuans = Pengajuan::with([
//             'mahasiswa',
//             'tipePengajuan', 
//             'operator', 
//             'periode'
//         ])->where('status', 'ditolak')->get();

//         return view('layouts.digitalisasi.pengajuan_ditolak_operator.index', compact('pengajuans'));
//     }



//     public function getDetailRejectedPengajuan(Request $request, $id) {
        
//         try {
//             //code...
//             $pengajuan = Pengajuan::with([
//                 'mahasiswa', 
//                 'tipePengajuan', 
//                 'operator', 
//                 'periode'
//                 ])->where('id', $id)->where('status', 'ditolak')->firstOrFail();
//                 return view('layouts.digitalisasi.pengajuan_ditolak_operator.pengajuan_ulang', compact('pengajuan'));
//             } catch (\Throwable $th) {
//                 //throw $th;
//                 return redirect()->back()->with('error', 'Data tidak ditemukan!');
//             }
//     }


//     public function pengajuanUlang(Request $request, $id) {
        
//         $request->validate([
//             'file_sk' => 'required|mimes:pdf|max:2048',
//             'file_sptjm' => 'required|mimes:pdf|max:2048',
//         ]);

//         $fileSk = $request->file('file_sk')->store('dokumen_sk', 'public');
//         $fileSptjm = $request->file('file_sptjm')->store('dokumen_sptjm', 'public');
//         $pengajuan = Pengajuan::findOrFail($id);
//         $pengajuan->file_sk = $fileSk;
//         $pengajuan->file_sptjm = $fileSptjm;
//         $pengajuan->status = 'diajukan';
//         $pengajuan->save();
//         $mahasiswa = Mahasiswa::findOrFail($pengajuan->mahasiswa_id);
//         $mahasiswa->status_pengajuan = 'diajukan';
//         $mahasiswa->save();


//         return redirect()->route('pengajuan_ditolak')->with('message', 'Pengajuan berhasil diajukan ulang.');
//     }
// }  