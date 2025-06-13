@extends('layouts.app')

@section('title', 'Upload SK dan SPTJM')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Upload Dokumen - Penetapan Awal</h1>
        </div>

        <form action="{{ route('pengajuan_penetapan.upload_dokumen_post',['periode_penetapan_id' => $periode_penetapan_id]) }}" method="POST" accept="application/pdf"
            enctype="multipart/form-data">
            @csrf

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