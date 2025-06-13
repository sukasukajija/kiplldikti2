@extends('layouts.app')

@section('title', 'Select Jenis Bantuan')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Jenis Bantuan - Pembatalan Ongoing</h1>
        </div>

        @if (session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        <form action="{{ route('pencairan.ongoing.pembatalan.post', ['periode_id' => $periode_id]) }}" method="POST" accept="application/pdf"
            enctype="multipart/form-data">
            @csrf


            <div class="form-group">
                <label>Pilih Jenis Bantuan</label>
                <select name="jenis_bantuan_id" class="form-control" required>
                    <option value="" selected disabled>-- Pilih Jenis Bantuan --</option>
                    @foreach ($jenisBantuan as $j)
                    <option value="{{ $j->id }}">{{ $j->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary btn-lg">Upload & Lanjutkan</button>
            </div>
        </form>
    </section>
</div>
@endsection