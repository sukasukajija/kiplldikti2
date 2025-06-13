<?php

namespace App\Http\Controllers;

use App\Models\PeriodePenetapan;
use App\Models\User;
use App\Notifications\PeriodeBaruNotification;
use Illuminate\Http\Request;

class PeriodePenetapanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        if ($search) {
        $periode = PeriodePenetapan::where(function($query) use ($search) {
            $query->where('tahun', 'like', "%{$search}%")
                  ->orWhere('semester', 'like', "%{$search}%")
                  ->orWhereRaw("CONCAT(tahun, ' ', semester) LIKE ?", ["%{$search}%"])
                  ->orWhereRaw("CONCAT(tahun, '/', semester) LIKE ?", ["%{$search}%"]);
        })->get();
    } else {
        $periode = PeriodePenetapan::all();
    }
    return view('layouts.digitalisasi.periode_penetapan.index', compact('periode'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('layouts.digitalisasi.periode_penetapan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tahun' => 'required',
            'semester' => 'required',
            'tanggal_dibuka' => 'required',
            'tanggal_ditutup' => 'required'
        ]);


        $validateDate = \Carbon\Carbon::parse($request->tanggal_ditutup);
        $validateDate2 = \Carbon\Carbon::parse($request->tanggal_dibuka);
        if($validateDate->lt($validateDate2)) {
            return redirect()->back()->with('error', 'Tanggal Ditutup harus lebih besar dari tanggal dibuka');
        }



        $check = PeriodePenetapan::where(function($q) use($request) {
             $q->whereBetween('tanggal_dibuka', [
                     $request->tanggal_dibuka,
                     $request->tanggal_ditutup
                 ])
               ->orWhereBetween('tanggal_ditutup', [
                     $request->tanggal_dibuka,
                     $request->tanggal_ditutup
                 ]);
         })->first();


        if ($check) {
             return redirect()->back()->with('error', 'Periode Penetapan Sudah Ada di Periode ' . $check->tahun . ' ' . $check->semester);
        }


        $periode = new PeriodePenetapan();
        $periode->tahun = $request->tahun;
        $periode->semester = $request->semester;
        $periode->tanggal_dibuka = $request->tanggal_dibuka;
        $periode->tanggal_ditutup = $request->tanggal_ditutup;



        if ($periode->save()) {
            return redirect()->route('periode_penetapan.index')->with('message', 'Data Berhasil Disimpan');
        }else
        {
            return redirect()->back()->with('error', 'Gagal Menyimpan Data');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $periode = PeriodePenetapan::find($id);



        return view('layouts.digitalisasi.periode_penetapan.edit', compact('periode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'tahun' => 'required',
            'semester' => 'required',
            'tanggal_dibuka' => 'required',
            'tanggal_ditutup' => 'required'
        ]);

        $validateDate = \Carbon\Carbon::parse($request->tanggal_ditutup);
        $validateDate2 = \Carbon\Carbon::parse($request->tanggal_dibuka);
        if($validateDate->lt($validateDate2)) {
            return redirect()->back()->with('error', 'Tanggal Ditutup harus lebih besar dari tanggal dibuka');
        }


        $check = PeriodePenetapan::where('id', '!=', $request->id)
            ->where(function($q) use($request) {
                $q->whereBetween('tanggal_dibuka', [
                        $request->tanggal_dibuka,
                        $request->tanggal_ditutup
                    ])
                    ->orWhereBetween('tanggal_ditutup', [
                        $request->tanggal_dibuka,
                        $request->tanggal_ditutup
                    ]);
            })->first();


        if ($check) {
            return redirect()->back()->with('error', 'Periode Penetapan Sudah Ada di Periode ' . $check->tahun . ' ' . $check->semester);
        }

        $periode = PeriodePenetapan::find($request->id);
        $periode->tahun = $request->tahun;
        $periode->semester = $request->semester;
        $periode->tanggal_dibuka = $request->tanggal_dibuka;
        $periode->tanggal_ditutup = $request->tanggal_ditutup;

        if ($periode->save()) {
            return redirect()->route('periode_penetapan.index')->with('message', 'Data Berhasil Diubah');
        }else
        {
            return redirect()->back()->with('error', 'Gagal Mengubah Data');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $periode = PeriodePenetapan::find($id);
        if ($periode->delete()) {
            return redirect()->route('periode_penetapan.index')->with('message', 'Data Berhasil Dihapus');
        }else
        {
            return redirect()->back()->with('error', 'Gagal Menghapus Data');
        }
    }


    public function setActive($periode_id){


        PeriodePenetapan::where('id', '!=', $periode_id)->update(['is_active' => false]);
        $periode = PeriodePenetapan::find($periode_id);
        $periode->is_active = true;
        $periode->save();

        $operators = User::where('role', 'operator')->get();
         foreach ($operators as $operator) {
             $operator->notify(new PeriodeBaruNotification($periode));
         }

        return redirect()->route('periode_penetapan.index')->with('message', 'Periode Aktif Berhasil Diubah');

    }
}
