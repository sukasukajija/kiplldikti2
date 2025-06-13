{{-- filepath: c:\xampp\htdocs\simkippp\resources\views\layouts\digitalisasi\pencairan_admin\reject.blade.php --}}
@extends('layouts.app')

@section('title', 'Pengajuan Penolakan')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Form Penolakan Pengajuan Pencairan</h1>
        </div>

        <div class="card mt-3">
            <div class="card-header bg-primary text-white">
                <h4 class="text-white">Detail Mahasiswa</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">Nama Mahasiswa</th>
                        <td>{{ $pencairan->mahasiswa->name }}</td>
                    </tr>
                    <tr>
                        <th>Perguruan Tinggi</th>
                        <td>{{ $pencairan->mahasiswa->perguruantinggi->nama_pt }}</td>
                    </tr>
                    <tr>
                        <th>Waktu pengajuan pencairan</th>
                        <td>{{ \Carbon\Carbon::parse($pencairan->created_at)->format('d M Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <form action="{{ route('pencairan_admin.reject.post', array_merge(['pencairan_id' => $pencairan->id], request()->only(['page', 'per_page', 'perguruan_tinggi_id', 'periode_id', 'tipe_pencairan', 'search']))) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @foreach(request()->only(['page', 'per_page', 'perguruan_tinggi_id', 'periode_id', 'tipe_pencairan', 'search']) as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach
            <div class="form-group">
                <label for="remarks">Alasan Penolakan</label>
                <textarea name="keterangan" id="remarks" class="form-control" rows="10" required></textarea>
            </div>
            <div class="form-group">
                <label for="dokumen">Dokumen Penolakan</label>
                <input type="file" name="dokumen_penolakan" id="dokumen" class="form-control" accept=".pdf" required>
            </div>
            <button type="submit" class="btn btn-danger">Submit</button>
        </form>

    </section>
</div>
@endsection
