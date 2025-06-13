<?php
namespace App\Helpers;
use App\Models\PeriodePenetapan;
use Illuminate\Support\Facades\Log;

class GetIdPeriodeBefore
{

    public static function get($id)
    {
        $periodePenetapanNow = PeriodePenetapan::where('id', $id)->first();

        // Check if the current period was found
        if (!$periodePenetapanNow) {
            Log::info('Periode Penetapan tidak ditemukan untuk ID: ' . $id);
            return [];
        }

        // Log the current period date
        Log::info('Periode Penetapan Sekarang: ' . $periodePenetapanNow->tanggal_dibuka);

        // Retrieve the previous periods with an earlier 'tanggal_dibuka'
        $periodeBefore = PeriodePenetapan::whereDate('tanggal_dibuka', '<', $periodePenetapanNow->tanggal_dibuka)
        ->orderBy('tanggal_dibuka', 'desc')
        ->get()
        ->pluck('id');

        // Log the retrieved previous periods
        Log::info('Periode Penetapan Sebelumnya: ' . $periodeBefore);

        return $periodeBefore;
    }

}

