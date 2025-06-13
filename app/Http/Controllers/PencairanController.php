<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Pencairan;
use App\Models\Perguruantinggi;
use App\Models\User;
use App\Notifications\PencairanToAdminNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PencairanController extends Controller
{
    // Fungsi untuk menampilkan daftar mahasiswa dengan status pencairan diajukan
    public function index()
    {
        $mahasiswa = Mahasiswa::with(['pencairan', 'perguruantinggi', 'programstudi'])
            ->where('status_pencairan', 'diajukan');

        $perguruan_tinggi = Perguruantinggi::all();

        if (isset($_GET['perguruan_tinggi_id']) && $_GET['perguruan_tinggi_id'] != null) {
            $mahasiswa = $mahasiswa->where('perguruan_tinggi_id', $_GET['perguruan_tinggi_id']);
        }

        $mahasiswa = $mahasiswa->get();

        return view('layouts.digitalisasi.mahasiswa_finalisasi.index', compact('mahasiswa', 'perguruan_tinggi'));
    }

    // Fungsi untuk menampilkan detail penolakan pencairan
    public function detailPenolakan($id)
    {
        // Ambil data pencairan beserta relasi yang diperlukan
        $pencairan = Pencairan::with([
            'mahasiswa.bank',
            'mahasiswa.perguruantinggi',
            'periode',
            'tipe_pengajuan'
        ])->findOrFail($id);

        return view('layouts.digitalisasi.detail_penolakan', compact('pencairan'));
    }

    // Fungsi untuk mengajukan ulang pencairan dengan dokumen baru
    public function ajukanUlang(Request $request, $id)
    {
        try {
            // Validasi file yang diunggah
            $request->validate([
                'file_sk' => 'required|mimes:pdf|max:2048',
                'file_sptjm' => 'required|mimes:pdf|max:2048',
            ]);

            $pencairan = Pencairan::findOrFail($id);

            // Hapus file lama jika ada
            if ($pencairan->file_sk) {
                Storage::delete('public/' . $pencairan->file_sk);
            }
            if ($pencairan->file_sptjm) {
                Storage::delete('public/' . $pencairan->file_sptjm);
            }

            // Simpan file baru
            $fileSkPath = $request->file('file_sk')->store('pencairan/sk', 'public');
            $fileSptjmPath = $request->file('file_sptjm')->store('pencairan/sptjm', 'public');

            // Update data pencairan
            $pencairan->update([
                'file_sk' => $fileSkPath,
                'file_sptjm' => $fileSptjmPath,
                'status' => 'diajukan', // Ubah status menjadi diajukan ulang
                'keterangan_penolakan' => null,
                'dokumen_penolakan' => null,
            ]);

            // Kirim notifikasi ke admin
            $admin = User::where('role', 'superadmin')->get();
            foreach ($admin as $item) {
                $item->notify(new PencairanToAdminNotification($pencairan));
            }

            return redirect()->route('operator.detail_penolakan', $id)->with('success', 'Pengajuan berhasil diajukan ulang.');
        } catch (\Throwable $th) {
            // Tangani error dan kembalikan pesan error
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }
}