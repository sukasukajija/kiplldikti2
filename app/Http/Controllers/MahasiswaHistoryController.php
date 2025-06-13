<?php

namespace App\Http\Controllers;

use App\Models\MahasiswaHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MahasiswaHistoryController extends Controller
{
    public function historyAdmin()
    {
        $operatorPTId = Auth::user()->pt_id;
    
        $latestHistory = MahasiswaHistory::select('mahasiswa_id', DB::raw('MAX(changed_at) as latest_changed_at'))
            ->groupBy('mahasiswa_id');
    
        $history = MahasiswaHistory::joinSub($latestHistory, 'latest_history', function ($join) {
                $join->on('mahasiswa_history.mahasiswa_id', '=', 'latest_history.mahasiswa_id')
                     ->on('mahasiswa_history.changed_at', '=', 'latest_history.latest_changed_at');
            })
            ->orderBy('mahasiswa_history.changed_at', 'desc')
            ->get();
    
        return view('layouts.digitalisasi.laporan.historylldikti', compact('history'));
    }
    
}
