{{-- filepath: c:\xampp\htdocs\simkippp\resources\views\layouts\digitalisasi\pengajuan_admin\reject.blade.php --}}
@extends('layouts.app')

@section('title', 'Pengajuan Penolakan')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Form Penolakan Penetapan Awal</h1>
        </div>

      <div class="card mt-3">
          <div class="card-header bg-primary text-white">
              <h4 class="text-white">Detail Mahasiswa</h4>
          </div>
          <div class="card-body">
              <table class="table table-bordered">
                  <tr>
                      <th width="30%">Nama Mahasiswa</th>
                      <td>{{ $pengajuan->mahasiswa->name }}</td>
                  </tr>
                  <tr>
                      <th>Perguruan Tinggi</th>
                      <td>{{ $pengajuan->mahasiswa->perguruantinggi->nama_pt }}</td>
                  </tr>
                  <tr>
                      <th>Tanggal Pengajuan</th>
                      <td>{{ \Carbon\Carbon::parse($pengajuan->created_at)->format('d M Y H:i') }}</td>
                  </tr>
              </table>
          </div>
      </div>

      <form action="{{ route('pengajuan_admin.rejectPost', $pengajuan->id) }}" method="POST">
        @csrf

        {{-- Simpan parameter query sebagai hidden input --}}
        @if(isset($queryParams))
            @foreach($queryParams as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach
        @endif

        <div class="form-group">
            <label for="remarks">Alasan Penolakan:</label>
            <textarea name="remarks" id="remarks" class="form-control" rows="4" required></textarea>
        </div>
        
        <button type="submit" class="btn btn-danger">Tolak Pengajuan</button>
        <a href="{{ route('pengajuan_admin.index', $queryParams ?? []) }}" class="btn btn-secondary">Batal</a>
      </form>

    </section>
</div>
@endsection