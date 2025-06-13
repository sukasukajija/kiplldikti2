@extends('layouts.app')

@section('title', 'Upload SPTJM')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Form Awal Penetapan Kembali</h1>
        </div>

        @if (session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        <form action="{{ route('pencairan.ongoing.penetapan-kembali.upload-dokumen.post', ['periode_id' => $periode_id, 'bank_id' => $bank_id ]) }}" method="POST" accept="application/pdf"
            enctype="multipart/form-data">
            @csrf


            <div class="form-group">
                <label>Bank</label>
                <input type="text" name="bank_name" class="form-control" value="{{ $bank->name }}" disabled  required>
            </div>

            <div class="form-group">
                <label>Pilih Jenis Bantuan</label>
                <select name="jenis_bantuan_id" class="form-control" required>
                    <option value="" selected disabled>-- Pilih Jenis Bantuan --</option>
                    @foreach ($jenisBantuan as $j)
                    <option value="{{ $j->id }}">{{ $j->name }}</option>
                    @endforeach
                </select>
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