@extends('layouts.app')

@section('title', 'Tambah Data Perguruan Tinggi')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('content')
<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Data PT</h1>
            </div>
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
                <form action="{{ route('perguruan_tinggi.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="kode_pt">Kode Perguruan Tinggi</label>
                        <input type="text" name="kode_pt" id="kode_pt" class="form-control" required maxlength="100">
                    </div>
                    <div class="form-group">
                        <label for="nama_pt">Nama Perguruan Tinggi</label>
                        <input type="text" name="nama_pt" id="nama_pt" class="form-control" required maxlength="125">
                    </div>

                   <div class="form-group">
                    <label for="klaster_id">Klaster Wilayah</label>
                    <select name="klaster_id" id="klaster_id" class="form-control" required>
                        <option value="">-- Pilih Klaster --</option>
                        @foreach($klasters as $klaster)
                            <option value="{{ $klaster->id }}">{{ $klaster->nama_klaster }}</option>
                        @endforeach
                    </select>
                 </div>


                 <div class="form-group">
                        <label for="no_rekening_bri">No Rekening BRI</label>
                        <input type="text" name="no_rekening_bri" id="no_rekening_bri" class="form-control" required maxlength="125">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
