@extends('layouts.app')

@section('title', 'Tambah Data Prodi')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('content')
<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Data Prodi {{Auth::user()->perguruantinggi->nama_pt}}</h1>
            </div>
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <form action="{{ route('program_studi.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="kode_prodi">Kode Prodi</label>
                        <input type="text" name="kode_prodi" id="kode_prodi" class="form-control" required maxlength="100">
                    </div>
                    <div class="form-group">
                        <label for="nama_prodi">Nama Prodi</label>
                        <input type="text" name="nama_prodi" id="nama_prodi" class="form-control" required maxlength="125">
                    </div>

                    <div class="form-group">
                        <label for="akreditasi">Akreditasi Prodi</label>
                        <input type="text" name="akreditasi" id="akreditasi" class="form-control" required maxlength="100">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
