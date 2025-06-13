@extends('layouts.app')

@section('title', 'Upload Ba Evaluasi')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Upload Ba Evaluasi</h1>
        </div>

        @if (session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        <form action="{{ route('evaluasi.upload-ba.post', ['periode_id' => $periode_id]) }}" method="POST" accept="application/pdf"
            enctype="multipart/form-data">
            @csrf


            <div class="form-group">
                <label>Upload BA (PDF)</label>
                <input type="file" name="file_ba" class="form-control" accept="application/pdf" required>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary btn-lg">Upload & Lanjutkan</button>
            </div>
        </form>
    </section>
</div>
@endsection