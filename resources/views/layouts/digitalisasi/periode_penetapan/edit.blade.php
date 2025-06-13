@extends('layouts.app')

@section('title', 'Edit Data Periode Penetapan')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Data Periode Penetapan</h1>
        </div>
        @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
        @endif
        <form action="{{ route('periode_penetapan.update', $periode->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="tahun">Tahun</label>
                    <input type="text" name="tahun" id="tahun"  class="form-control" value="{{ $periode->tahun }}"  maxlength="100">
                </div>

                <div class="form-group">
                    <label for="semester">Semester</label>
                    <input type="text" name="semester" id="semester"  class="form-control" value="{{ $periode->semester }}"  maxlength="100">
                </div>

                <div class="form-group">
                    <label for="tanggal_dibuka">Tanggal Dibuka</label>
                    <input type="date" name="tanggal_dibuka" id="tanggal_dibuka" class="form-control" value="{{ $periode->tanggal_dibuka }}" maxlength="125">
                </div>
                <div class="form-group">
                    <label for="tanggal_ditutup">Tanggal Ditutup</label>
                    <input type="date" name="tanggal_ditutup" id="tanggal_ditutup" class="form-control" value="{{ $periode->tanggal_ditutup }}" maxlength="125">
                </div>
                
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </section>
</div>
@endsection
