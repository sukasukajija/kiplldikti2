@extends('layouts.app')

@section('title', 'Tambah User')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('content')
<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah User</h1>
            </div>
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
                <form action="{{ route('hakakses.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control" required maxlength="100">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required maxlength="125">
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required maxlength="125">
                    </div>
                    
                    <div class="form-group">
                        <label for="pt_id">Perguruan Tinggi</label>
                        <select name="pt_id" id="pt_id" class="form-control" required>
                            <option value="">-- Select --</option>
                            @foreach($perguruanTinggi as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_pt }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
