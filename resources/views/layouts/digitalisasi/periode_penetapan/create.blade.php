@extends('layouts.app')

@section('title', 'Tambah Data Periode Penetapan')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('content')
<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Data Periode Penetapan</h1>
            </div>
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
                <form action="{{ route('periode_penetapan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="tahun">Tahun</label>
                        <select name="tahun" id="tahun" class="form-control">
                            @php
                                $currentYear = date('Y');
                                for ($i = 0; $i < 10; $i++) { // Menampilkan 10 tahun ke depan
                                    $startYear = $currentYear + $i;
                                    $endYear = $startYear + 1;
                                    echo "<option value='$startYear/$endYear'>$startYear/$endYear</option>";
                                }
                            @endphp
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="semester">Semester</label>
                        <select name="semester" id="semester" class="form-control">
                            <option value="Ganjil">Ganjil</option>
                            <option value="Genap">Genap</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="tanggal_dibuka">Tanggal Dibuka</label>
                        <input type="date" name="tanggal_dibuka" id="tanggal_dibuka" class="form-control" maxlength="125">
                    </div>
                    <div class="form-group">
                        <label for="tanggal_ditutup">Tanggal Ditutup</label>
                        <input type="date" name="tanggal_ditutup" id="tanggal_ditutup" class="form-control" maxlength="125">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
