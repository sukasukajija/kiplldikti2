<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Pencairan;
use App\Models\Pengajuan;
use App\Models\Perguruantinggi;
use App\Models\PeriodePenetapan;
use App\Models\Programstudi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function admin(Request $request)
   {

      $periodeActive = PeriodePenetapan::where('is_active', 1)->first();

      $periodeId =  $request->input('periode_id') ?? null;

      if(is_null($periodeId)){

         if($periodeActive){

            $periodeId = $periodeActive->id;
         } else {

            $periodeId = 1;
         }
      }

      $periode = PeriodePenetapan::find($periodeId);
      $periodes = PeriodePenetapan::orderBy('tanggal_dibuka', 'asc')->get();


      $totalPt = Perguruantinggi::all()->count();
      
      $totalPengajuanDiajukan = Pengajuan::where('periode_id', $periodeId)->where('status', 'diajukan')->count();
      $totalPengajuanDisetujui = Pengajuan::where('periode_id', $periodeId)->where('status', 'disetujui')->count();
      
      $totalPencairanBaruDiajukan = Pencairan::where('periode_id', $periodeId)->where('tipe_pencairan', 'ajukan')->where('status', 'diajukan')->count();
      $totalPencairanBaruDisetujui = Pencairan::where('periode_id', $periodeId)->where('tipe_pencairan', 'ajukan')->where('status', 'disetujui')->count();
      
      $totalPencairanOngoingDiajukan = Pencairan::where('periode_id', $periodeId)->where('tipe_pencairan', 'penetapan_kembali')->where('status', 'diajukan')->count();
      $totalPencairanOngoingDisetujui = Pencairan::where('periode_id', $periodeId)->where('tipe_pencairan', 'penetapan_kembali')->where('status', 'disetujui')->count();
      
      $totalUktSPPBaru = Mahasiswa::whereHas('pencairan', function ($query) use ($periodeId) {
         $query->where('periode_id', $periodeId)
         ->where('status', 'disetujui')
         ->where('tipe_pencairan', 'ajukan');
      })->sum('ukt_spp');
      $totalUktSPPOngoing = Mahasiswa::whereHas('pencairan', function ($query) use ($periodeId) {
         $query->where('periode_id', $periodeId)
         ->where('status', 'disetujui')
         ->where('tipe_pencairan', 'penetapan_kembali');
      })->sum('ukt_spp');

      

      $perguruanTinggi = Perguruantinggi::paginate(5);

      foreach($perguruanTinggi->items() as $pt){
         
        //Penetapan Awal
         $pengajuanDiajukan = Pengajuan::where('periode_id', $periodeId)
         ->where('status', 'diajukan')
         ->whereHas('mahasiswa', function ($query) use ($pt) {
            $query->where('perguruan_tinggi_id', $pt->id);  
         })
         ->count();
         $pengajuanDisetujui = Pengajuan::where('periode_id', $periodeId)
         ->where('status', 'disetujui')
         ->whereHas('mahasiswa', function ($query) use ($pt) {
            $query->where('perguruan_tinggi_id', $pt->id);  
         })
         ->count();

         //Pencairan Baru
            $pencairanBaruDiajukan = Pencairan::where('periode_id', $periodeId)
            ->where('tipe_pencairan', 'ajukan')
            ->where('status', 'diajukan')
            ->whereHas('mahasiswa', function ($query) use ($pt) {
                $query->where('perguruan_tinggi_id', $pt->id);  
            })
            ->count();
            $pencairanBaruDisetujui = Pencairan::where('periode_id', $periodeId)
            ->where('tipe_pencairan', 'ajukan')
            ->where('status', 'disetujui')
            ->whereHas('mahasiswa', function ($query) use ($pt) {
                $query->where('perguruan_tinggi_id', $pt->id);  
            })
            ->count();
         //Pencairan Ongoing
            $pencairanOngoingDiajukan = Pencairan::where('periode_id', $periodeId)
            ->where('tipe_pencairan', 'penetapan_kembali')
            ->where('status', 'diajukan')
            ->whereHas('mahasiswa', function ($query) use ($pt) {
                $query->where('perguruan_tinggi_id', $pt->id);      
                })
            ->count();

            
            $pencairanOngoingDisetujui = Pencairan::where('periode_id', $periodeId)
            ->where('tipe_pencairan', 'penetapan_kembali')
            ->where('status', 'disetujui')
            ->whereHas('mahasiswa', function ($query) use ($pt) {
                $query->where('perguruan_tinggi_id', $pt->id);      
                })
            ->count();
         //UKT/SPP Pencairan Baru
            $uktSppBaru = Mahasiswa::where('perguruan_tinggi_id', $pt->id)
            ->whereHas('pencairan', function ($query) use ($periodeId) {
                $query->where('periode_id', $periodeId)
                ->where('status', 'disetujui')
                ->where('tipe_pencairan', 'ajukan');   
            })
            ->sum('ukt_spp');
         //UKT/SPP Pencairan Ongoing
            $uktSppOngoing = Mahasiswa::where('perguruan_tinggi_id', $pt->id)
            ->whereHas('pencairan', function ($query) use ($periodeId) {
                $query->where('periode_id', $periodeId)
                ->where('status', 'disetujui')
                ->where('tipe_pencairan', 'penetapan_kembali');
            })
            ->sum('ukt_spp');

         $pt->pengajuanDiajukan = $pengajuanDiajukan;
         $pt->pengajuanDisetujui = $pengajuanDisetujui;
         $pt->pencairanBaruDiajukan = $pencairanBaruDiajukan;
         $pt->pencairanBaruDisetujui = $pencairanBaruDisetujui;
         $pt->pencairanOngoingDiajukan = $pencairanOngoingDiajukan;
         $pt->pencairanOngoingDisetujui = $pencairanOngoingDisetujui;
         $pt->uktSppBaru = $uktSppBaru;
         $pt->uktSppOngoing = $uktSppOngoing;
      }

      return view('layouts.dashboard.admin', compact('perguruanTinggi', 'totalPt', 'totalPengajuanDiajukan', 'totalPengajuanDisetujui', 'totalPencairanBaruDiajukan', 'totalPencairanBaruDisetujui', 'totalPencairanOngoingDiajukan', 'totalPencairanOngoingDisetujui', 'totalUktSPPBaru', 'totalUktSPPOngoing', 'periode', 'periodes'));

   }

public function getChartData(Request $request)
{
    // Ambil periode_id dari request (jika ada)
    $periodeId = $request->input('periode_id');

    // Ambil semua perguruan tinggi
    $perguruanTinggi = Perguruantinggi::all();

    // Data untuk chart
    $labels = [];
    $eligibleData = [];
    $notEligibleData = [];

    foreach ($perguruanTinggi as $pt) {
        $labels[] = $pt->nama_pt; // Ambil nama perguruan tinggi

        // Hitung jumlah mahasiswa eligible (disetujui)
        $eligibleCount = Mahasiswa::where('perguruan_tinggi_id', $pt->id)
            ->whereHas('pengajuan', function ($query) use ($periodeId) {
                $query->where('status', 'disetujui');
                if ($periodeId) {
                    $query->where('periode_id', $periodeId);
                }
            })
            ->count();

        // Hitung jumlah mahasiswa tidak eligible (ditolak)
        $notEligibleCount = Mahasiswa::where('perguruan_tinggi_id', $pt->id)
            ->whereHas('pengajuan', function ($query) use ($periodeId) {
                $query->where('status', 'ditolak');
                if ($periodeId) {
                    $query->where('periode_id', $periodeId);
                }
            })
            ->count();

        // Masukkan data ke array
        $eligibleData[] = $eligibleCount;
        $notEligibleData[] = $notEligibleCount;
    }

    // Return JSON untuk frontend
    return response()->json([
        'labels' => $labels,
        'eligibleData' => $eligibleData,
        'notEligibleData' => $notEligibleData,
    ]);
}

    public function opt(Request $request)
    {

      $periodeActive = PeriodePenetapan::where('is_active', 1)->first();

      $periodeId =  $request->input('periode_id') ?? null;

      if(is_null($periodeId)){

         if($periodeActive){

            $periodeId = $periodeActive->id;
         } else {

            $periodeId = 1;
         }
      }

      $periode = PeriodePenetapan::find($periodeId);
      $periodes = PeriodePenetapan::orderBy('tanggal_dibuka', 'asc')->get();

      // Penetapan Awal
      $totalProdi = Programstudi::where('perguruan_tinggi_id', Auth::user()->pt_id)->count();
      $totalPengajuanDiajukan = Pengajuan::where('periode_id', $periodeId)
      ->where('status', 'diajukan')
      ->whereHas('mahasiswa', function ($query) {
            $query->where('perguruan_tinggi_id', Auth::user()->pt_id);  
      })
      ->count();
      $totalPengajuanDisetujui = Pengajuan::where('periode_id', $periodeId)
      ->where('status', 'disetujui')
      ->whereHas('mahasiswa', function ($query) {
            $query->where('perguruan_tinggi_id', Auth::user()->pt_id);  
      })->count();

      // Pencairan Baru
      $ptId = Auth::user()->perguruan_tinggi_id;

      
      $totalPencairanBaruDiajukan = Pencairan::where('periode_id', $periodeId)
      ->where('status', 'diajukan')
      ->where('tipe_pencairan', 'ajukan')
      ->whereHas('mahasiswa', function($q) use ($ptId) {
          $q->where('perguruan_tinggi_id', $ptId);
      })
      ->count();
    
        $totalPencairanBaruDisetujui = Pencairan::where('periode_id', $periodeId)
        ->where('status', 'disetujui')
        ->where('tipe_pencairan', 'ajukan')
        ->whereHas('mahasiswa', function ($query) {
          $query->where('perguruan_tinggi_id', Auth::user()->pt_id);
      })->count();

      // Pencairan Ongoing
        $totalPencairanOngoingDiajukan = Pencairan::where('periode_id', $periodeId)
        ->where('status', 'diajukan')
        ->where('tipe_pencairan', 'penetapan_kembali')      
        ->whereHas('mahasiswa', function ($query) {
            $query->where('perguruan_tinggi_id', Auth::user()->pt_id);
        })->count();
        
        $totalPencairanOngoingDisetujui = Pencairan::where('periode_id', $periodeId)
        ->where('status', 'disetujui')
        ->where('tipe_pencairan', 'penetapan_kembali')      
        ->whereHas('mahasiswa', function ($query) {
            $query->where('perguruan_tinggi_id', Auth::user()->pt_id);
        })
        ->count();
        
        // UKT/SPP Pencairan Baru
        $totalUktSPPBaru = Mahasiswa::where('perguruan_tinggi_id', Auth::user()->pt_id)
        ->whereHas('pencairan', function ($query) use ($periodeId) {
            $query->where('periode_id', $periodeId)
            ->where('status', 'disetujui')
            ->where('tipe_pencairan', 'ajukan');
        })->sum('ukt_spp');

        // UKT/SPP Pencairan Ongoing
        $totalUktSPPOngoing = Mahasiswa::where('perguruan_tinggi_id', Auth::user()->pt_id)
        ->whereHas('pencairan', function ($query) use ($periodeId) {
            $query->where('periode_id', $periodeId)
            ->where('status', 'disetujui')
            ->where('tipe_pencairan', 'penetapan_kembali');
        })->sum('ukt_spp');
       

     $programStudi = Programstudi::where('perguruan_tinggi_id', Auth::user()->pt_id)->paginate(5);

      foreach($programStudi->items() as $ps){


        //Penetapan Awal
         $pengajuanDiajukan = Pengajuan::where('periode_id', $periodeId)
         ->where('status', 'diajukan')
         ->whereHas('mahasiswa', function ($query) use ($ps) {
            $query->where('program_studi_id', $ps->id);
         })
         ->count();
         $pengajuanDisetujui = Pengajuan::where('periode_id', $periodeId)
         ->where('status', 'disetujui')
         ->whereHas('mahasiswa', function ($query) use ($ps) {
            $query->where('program_studi_id', $ps->id);  
         })
         ->count();

        //Pencairan Baru
         $pencairanBaruDiajukan = Pencairan::where('periode_id', $periodeId)
         ->where('status', 'diajukan')
         ->where('tipe_pencairan', 'ajukan')
         ->whereHas('mahasiswa', function ($query) use ($ps) {
            $query->where('program_studi_id', $ps->id);  
         })
         ->count();

         $pencairanBaruDisetujui = Pencairan::where('periode_id', $periodeId)
         ->where('status', 'disetujui')
         ->where('tipe_pencairan', 'ajukan')
         ->whereHas('mahasiswa', function ($query) use ($ps) {
            $query->where('program_studi_id', $ps->id);  
         })
         ->count();

        //Pencairan Ongoing
         $pencairanOngoingDiajukan = Pencairan::where('periode_id', $periodeId)
         ->where('status', 'diajukan')
         ->where('tipe_pencairan', 'penetapan_kembali')
         ->whereHas('mahasiswa', function ($query) use ($ps) {
            $query->where('program_studi_id', $ps->id);  
         })
         ->count();
         $pencairanOngoingDisetujui = Pencairan::where('periode_id', $periodeId)
         ->where('status', 'disetujui')
         ->where('tipe_pencairan', 'penetapan_kembali')
         ->whereHas('mahasiswa', function ($query) use ($ps) {
            $query->where('program_studi_id', $ps->id);  
         })
         ->count();
         
        //UKT/SPP Pencairan Baru         
         $uktSppBaru = Mahasiswa::where('program_studi_id', $ps->id)
         ->whereHas('pencairan', function ($query) use ($periodeId) {
             $query->where('periode_id', $periodeId)
             ->where('status', 'disetujui')
             ->where('tipe_pencairan', 'ajukan');   
            })
            ->sum('ukt_spp');

        //UKT/SPP Pencairan Ongoing
            $uktSppOngoing = Mahasiswa::where('program_studi_id', $ps->id)
            ->whereHas('pencairan', function ($query) use ($periodeId) {
                $query->where('periode_id', $periodeId)
                ->where('status', 'disetujui')
                ->where('tipe_pencairan', 'penetapan_kembali');
            })
            ->sum('ukt_spp');

         $ps->pengajuanDiajukan = $pengajuanDiajukan;
         $ps->pengajuanDisetujui = $pengajuanDisetujui;
         $ps->pencairanBaruDiajukan = $pencairanBaruDiajukan;
         $ps->pencairanBaruDisetujui = $pencairanBaruDisetujui;
         $ps->pencairanOngoingDiajukan = $pencairanOngoingDiajukan;
         $ps->pencairanOngoingDisetujui = $pencairanOngoingDisetujui;
         $ps->uktSppBaru = $uktSppBaru;
         $ps->uktSppOngoing = $uktSppOngoing;

      }
         
        return view('layouts.dashboard.operator', compact(
            'totalProdi',
            'totalPengajuanDiajukan',
            'totalPengajuanDisetujui',
            'totalPencairanBaruDiajukan',
            'totalPencairanBaruDisetujui',
            'totalPencairanOngoingDiajukan',
            'totalPencairanOngoingDisetujui',
            'totalUktSPPBaru',
            'totalUktSPPOngoing',
            'programStudi',
            'periode',
            'periodes'
        ));
    }

    public function getChartDataOpt(Request $request)
{
    $periodeId = $request->input('periode_id');

    $programStudi = Programstudi::where('perguruan_tinggi_id',Auth::user()->pt_id)->get();

    // dd($programStudi);

    $labels = [];
    $eligibleData = [];
    $notEligibleData = [];

    foreach ($programStudi as $pt) {
        $labels[] = $pt->nama_prodi; // Ambil nama perguruan tinggi

        // Hitung jumlah mahasiswa eligible (disetujui)
        $eligibleCount = Mahasiswa::where('program_studi_id', $pt->id)
        ->where('perguruan_tinggi_id',Auth::user()->pt_id)
            ->whereHas('pengajuan', function ($query) use ($periodeId) {
                $query->where('status', 'disetujui');
                if ($periodeId) {
                    $query->where('periode_id', $periodeId);
                }
            })
            ->count();

        // Hitung jumlah mahasiswa tidak eligible (ditolak)
        $notEligibleCount = Mahasiswa::where('program_studi_id', $pt->id)
        ->where('perguruan_tinggi_id',Auth::user()->pt_id)
            ->whereHas('pengajuan', function ($query) use ($periodeId) {
                $query->where('status', 'ditolak');
                if ($periodeId) {
                    $query->where('periode_id', $periodeId);
                }
            })
            ->count();

        // Masukkan data ke array
        $eligibleData[] = $eligibleCount;
        $notEligibleData[] = $notEligibleCount;
    }

    // Return JSON untuk frontend
    return response()->json([
        'labels' => $labels,
        'eligibleData' => $eligibleData,
        'notEligibleData' => $notEligibleData,
    ]);
}

}