@extends('layouts.app')

@section('title', 'Pengajuan Awal Ditolak')

@section('content')


<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Data Ditolak Penetapan Awal</h1>
        </div>

        @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif

        <div class="section-body">
            <div class="table-responsive">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <a href="{{ route('periode_penetapan.create') }}" class="btn btn-primary mb-3">Tambah Data</a>
                        <form action="{{ route('periode_penetapan.index') }}" method="GET">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control"
                                    placeholder="Cari Berdasarkan Nama Klaster...">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" style="margin-left:5px;"
                                        type="submit">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>



                <table class="table table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th>#</th>
                            <th>Nama Mahasiswa</th>
                            <th>Periode</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if($pengajuans->isEmpty())
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data pengajuan ditolak</td>
                        </tr>

                        @endif

                        @foreach ($pengajuans as $item)
                        <tr class="text-center">

                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->mahasiswa->name }}</td>
                            <td>{{ $item->periode->tahun }} {{ $item->periode->semester }}</td>
                            <td>
                                <p class="m-auto badge badge-danger">{{ ucfirst($item->status) }}</p>
                            </td>
                            <td>
                                <a href="{{ route('pengajuan_ditolak.detail', $item->id) }}" class="btn btn-success">
                                    Pengajuan ulang</a>
                                <a href="{{ route('mahasiswa.edit', $item->mahasiswa->id) }}" class="btn btn-primary">
                                    Edit mahasiswa</a>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

@endsection