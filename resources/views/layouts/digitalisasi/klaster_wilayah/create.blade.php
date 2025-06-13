@extends('layouts.app')

@section('title', 'Tambah Data Klaster')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('content')
<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Data Klaster</h1>
            </div>
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
                <form action="{{ route('klaster_wilayah.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="nama_klaster">Nama Klaster</label>
                        <input type="text" name="nama_klaster" id="nama_klaster" class="form-control" required maxlength="100">
                    </div>
                    <div class="form-group">
                        <label for="biaya_hidup">Biaya Hidup</label>
                        <input type="number" name="biaya_hidup" id="biaya_hidup" class="form-control" required maxlength="125">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
