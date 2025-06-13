@extends('layouts.app')

@section('title', 'Upload SK dan SPTJM')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Upload Dokumen</h1>
        </div>

        @if (session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        <form action="{{ route('pencairan.store') }}" method="POST" accept="application/pdf"
            enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="tipe" value="{{ $tipe }}">
            <input type="hidden" name="bank_id" value="{{ $bank_id }}">


            <div class="form-group">
                <label>Upload BA (PDF)</label>
                <input type="file" name="file_ba" class="form-control" accept="application/pdf" required>
            </div>

            <div class="form-group">
                <label>Upload SK (PDF)</label>
                <input type="file" name="file_sk" class="form-control" accept="application/pdf" required>
            </div>

            <div class="form-group">
                <label>Upload SPTJM (PDF)</label>
                <input type="file" name="file_sptjm" class="form-control" accept="application/pdf" required>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary btn-lg">Upload & Lanjutkan</button>
            </div>
        </form>
    </section>
</div>
@endsection