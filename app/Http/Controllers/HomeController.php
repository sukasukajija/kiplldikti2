<?php

namespace App\Http\Controllers;

use App\Models\PeriodePenetapan;
use Illuminate\Http\Request;
use App\Models\Tahunpenerimaan;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // dd(Auth::user()->role);
        $periode = PeriodePenetapan::get();
        return view('home',compact('periode'));
    }

    public function blank()
    {
        return view('layouts.blank-page');
    }
}
