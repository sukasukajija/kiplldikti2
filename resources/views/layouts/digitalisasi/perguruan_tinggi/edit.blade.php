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
        <form action="{{ route('perguruan_tinggi.update', $perguruan_tinggi->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="kode_pt">Kode Perguruan Tinggi</label>
                    <input type="text"  name="kode_pt" id="kode_pt" class="form-control" value="{{ $perguruan_tinggi->kode_pt }}"  maxlength="100">
                </div>

                <div class="form-group">
                    <label for="nama_pt">Nama Perguruan Tinggi</label>
                    <input type="text" name="nama_pt" id="nama_pt" class="form-control" value="{{ $perguruan_tinggi->nama_pt }}" maxlength="125">
                </div>
                <div class="form-group">
                    <label for="klaster_id">Klaster Wilayah</label>
                    <select name="klaster_id" id="klaster_id" class="form-control" required>
                        <option value="" selected disabled>Pilih Klaster Wilayah</option>
                        @if(isset($perguruan_tinggi) && optional($perguruan_tinggi->klaster)->id)
                            <option value="{{ $perguruan_tinggi->klaster_id }}" selected>
                                {{ $perguruan_tinggi->klaster->nama_klaster }}
                            </option>
                        @endif
                        @foreach($klasters as $klaster)
                            <option value="{{ $klaster->id }}">{{ $klaster->nama_klaster }}</option>
                        @endforeach
                    </select>
                </div>
                

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </section>
</div>
@endsection
