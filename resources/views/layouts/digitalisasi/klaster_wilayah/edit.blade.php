@extends('layouts.app')

@section('title', 'Edit Data Perguruan Tinggi')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Data Perguruan tinggi</h1>
        </div>
        @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
        @endif
        <form action="{{ route('klaster_wilayah.update', $klaster->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nama_klaster">Nama Klaster</label>
                    <input type="text" name="nama_klaster" id="nama_klaster"  class="form-control" value="{{ $klaster->nama_klaster }}"  maxlength="100">
                </div>

                <div class="form-group">
                    <label for="biaya_hidup">Biaya Hidup</label>
                    <input type="number" name="biaya_hidup" id="biaya_hidup" class="form-control" value="{{ $klaster->biaya_hidup }}" maxlength="125">
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </section>
</div>
@endsection
