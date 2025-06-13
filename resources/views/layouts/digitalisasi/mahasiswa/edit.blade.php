@extends('layouts.app')

@section('title', 'Edit Mahasiswa')

@section('content')
<div class="main-content">
    <section class="section" style="padding-bottom: 200px">
        <div class="section-header">
            <h1>Edit Mahasiswa</h1>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif


        <form action="{{ route('mahasiswa.update', $mahasiswa->id) }}" method="POST" enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="form-group">
                <label>NIM</label>
                <input type="text" name="nim" class="form-control" value="{{ $mahasiswa->nim }}" required>
            </div>

            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="name" class="form-control" value="{{ $mahasiswa->name }}" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ $mahasiswa->email }}" required>
            </div>

            <div class="form-group">
                <label>GPA</label>
                <input type="number" step="0.01" name="gpa" class="form-control" value="{{ $mahasiswa->gpa }}">
            </div>

            <div class="form-group">
                <label>Perguruan Tinggi</label>
                <input class="form-control" type="text" value="{{ $mahasiswa->perguruantinggi->nama_pt }}" disabled>
                <input type="hidden" name="perguruan_tinggi_id" value="{{ $mahasiswa->perguruantinggi->id }}">
            </div>


            <div class="form-group">
                <label>Program Studi</label>
                <select name="program_studi_id" class="form-control" required>
                    @foreach ($programStudi as $ps)
                        <option value="{{ $ps->id }}" {{ $mahasiswa->program_studi_id == $ps->id ? 'selected' : '' }}>
                            {{ $ps->nama_prodi }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Status Pengajuan</label>
                <select class="form-control" required disabled>
                    <option value="diajukan" {{ $mahasiswa->status_pengajuan == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                    <option value="belumDiajukan" {{ $mahasiswa->status_pengajuan == 'belumDiajukan' ? 'selected' : '' }}>Belum Diajukan</option>
                </select>
                <input type="hidden" name="status_pengajuan" value="{{ $mahasiswa->status_pengajuan }}">
            </div>
            

            <div class="form-group">
                <label>Status Mahasiswa</label>
                <select name="status_mahasiswa" class="form-control" required>
                    <option value="aktif" {{ $mahasiswa->status_mahasiswa == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ $mahasiswa->status_mahasiswa == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    <option value="cuti" {{ $mahasiswa->status_mahasiswa == 'cuti' ? 'selected' : '' }}>Cuti</option>
                    <option value="lulus" {{ $mahasiswa->status_mahasiswa == 'lulus' ? 'selected' : '' }}>Lulus</option>
                </select>
            </div>
            

            <!-- Gunakan flexbox untuk mengatur tombol di kanan -->
<div class="form-group d-flex justify-content-end">
    <button type="submit" class="btn btn-primary btn-lg">Update</button>
</div>

            
        </form>
    </section>
</div>
@endsection
