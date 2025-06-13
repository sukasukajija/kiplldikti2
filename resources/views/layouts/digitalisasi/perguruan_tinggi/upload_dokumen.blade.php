@extends('layouts.app')

@section('title', 'Unggah Dokumen')

@section('content')
    <div class="main-content">
        <section class="section" style="padding-bottom: 200px">
            <div class="section-header">
                <h1>Unggah Dokumen</h1>
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


            <form action="{{ route('perguruan_tinggi.store_dokumen', $perguruantinggi) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>Upload File SK (PDF)</label>
                    <input type="file" name="file_sk" class="form-control" accept="application/pdf">
                </div>

                <div class="form-group">
                    <label>Upload File SPTJM (PDF)</label>
                    <input type="file" name="file_sptjm" class="form-control" accept="application/pdf">
                </div>

                <!-- Gunakan flexbox untuk mengatur tombol di kanan -->
                <div class="form-group d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary btn-lg">Upload Dokumen</button>
                </div>


            </form>
        </section>
    </div>
@endsection
