@extends('layouts.app')

@section('title', 'Evaluasi Mahasiswa')

@section('content')
<div class="main-content">
    <section class="section" style="padding-bottom: 200px">
        <div class="section-header">
            <h1>Evaluasi Mahasiswa</h1>
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


        <form action="{{ route('evaluasi.store', ['periode_id' => $periode_id, 'mahasiswa_id' => $mahasiswa->id]) }}" method="POST" enctype="multipart/form-data">

            @csrf
            @method('POST')

            <div class="form-group">
                <label>NIM</label>
                <input type="text" name="nim" class="form-control" value="{{ $mahasiswa->nim }}" required disabled>
            </div>

            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="name" class="form-control" value="{{ $mahasiswa->name }}" required disabled>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ $mahasiswa->email }}" required disabled>
            </div>

            <div class="form-group">
                <label>IPK</label>
                <input type="number" step="0.01" name="gpa" class="form-control" value="{{ $mahasiswa->gpa }}">
            </div>


            <div class="form-group">
                <label>Semester</label>
                <input type="number" min="{{ $mahasiswa->semester }}" max="14" name="semester" class="form-control" value="{{ $mahasiswa->semester }}">
            </div>

            <div class="form-group">
                <label>Pilih Bank</label>
                <select name="bank_id" class="form-control" required>
                    @if (! $mahasiswa->bank_id)
                        <option value="">Pilih Bank</option>
                    @endif
                    @foreach ($bank as $b)
                        <option value="{{ $b->id }}" {{ $mahasiswa->bank_id == $b->id ? 'selected' : '' }}>
                            {{ $b->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Nama Rekening</label>
                <input type="text" name="nama_rekening" class="form-control" value="{{ $mahasiswa->nama_rekening_bank }}">
            </div>

            <div class="form-group">
                <label>No Rekening</label>
                <input type="text" name="no_rekening" class="form-control" value="{{ $mahasiswa->no_rekening_bank }}">
            </div>


            <div class="form-group">
                <label>Perguruan Tinggi</label>
                <input class="form-control" type="text" value="{{ $mahasiswa->perguruantinggi->nama_pt }}" disabled>
                <input type="hidden" name="perguruan_tinggi_id" value="{{ $mahasiswa->perguruantinggi->id }}">
            </div>


            <div class="form-group">
                <label>Program Studi</label>
                <select name="program_studi_id" class="form-control" required disabled>
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
                <label>Transkrip</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="transkrip" accept=".pdf" required name="file_transkrip">
                </div>
            </div>

            <div class="form-group">
                <label>Pendapatan Orang Tua/Wali Per Bulan</label>
                <select class="form-control" required name="pendapatan_id">
                    <option value="">Pilih</option>
                    @foreach ($pendapatan as $p)
                        <option value="{{ $p->id }}" {{ count($mahasiswa?->evaluasi) &&  $mahasiswa?->evaluasi[0]?->pendapatan_id == $p->id ? 'selected' : '' }}><span class="text-capitalize">{{ $p->keterangan }} </span> ( {{$p->min_pendapatan ?? 0}} - {{$p->max_pendapatan ?? "Unlimited" }} )</option>
                    @endforeach
                </select>
            </div>

            <!-- Gunakan flexbox untuk mengatur tombol di kanan -->
         <div class="form-group d-flex justify-content-end">
             <button type="submit" class="btn btn-primary btn-lg">Evaluasi</button>
         </div>

            
        </form>
    </section>
</div>
@endsection
