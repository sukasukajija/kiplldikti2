<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use App\Models\Pencairan;
use App\Models\Pengajuan;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Row;

class PencairanImport implements OnEachRow, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function onRow(Row $row)
    {
      try {
         //code...

      DB::beginTransaction();
      
      $data = $row->toArray();



      if(!$data['nik'] || !$data['pin']) {
         return;
      }

      $mahasiswa = Mahasiswa::where('nik', $data['nik'])->whereHas('pengajuan')->first();

      $mahasiswa->update([
         'status_pencairan' => 'diajukan',
         'pin' => $data['pin'],
      ]);



      DB::commit();

      } catch (\Throwable $th) {
         DB::rollBack();
         Log::info("Error Import Pencairan : ", [
            'message' => $th->getMessage(),
            'getTrice' => $th->getTraceAsString(),
         ]);
      }
    }
}