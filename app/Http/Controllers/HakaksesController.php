<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\hakakses;
use App\Models\Perguruantinggi;
use Illuminate\Http\Request;

class HakaksesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        if ($search) {
            $data['user'] = User::where('name', 'like', "%{$search}%")->get();
        } else {
            $data['user'] = User::all();
        }
        return view('layouts.digitalisasi.hakakses.index', $data);
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    public function create()
    {
        $perguruanTinggi = Perguruantinggi::all();
        return view('layouts.digitalisasi.hakakses.create',compact('perguruanTinggi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = new User();
        $user->name = $request->nama;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = 'operator';
        $user->pt_id = $request->pt_id;
        if($user->save()){
            return redirect()->route('hakakses.index')->with('message', 'User Berhasil Dibuat');
        }else{
            return redirect()->route('hakakses.index')->with('error', 'User Gagal Dibuat');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $user = User::find($id);
        return view('layouts.digitalisasi.hakakses.edit', compact('user'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, user $user, $id)
    {
        
        $user = User::find($id);
        $user->role = $request->role;
        if ($user->save()) {
            return redirect()->route('hakakses.index')->with('message', 'Data User Berhasil Diubah.');
        }
        return redirect()->back()->with('error', 'Gagal Mengubah Data User.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if ($user->delete()) {
            return redirect()->route('hakakses.index')->with('message', 'Data User Berhasil Dihapus.');
        } else {
            return redirect()->back()->with('error', 'Gagal Menghapus Data User.');
        }
        return redirect()->route('hakakses.index');
    }
}
