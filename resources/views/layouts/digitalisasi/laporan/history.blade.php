@extends('layouts.app')

@section('title', 'History Pengajuan')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>History Mahasiswa</h1>
        </div>
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th>#</th>
                            <th>Nama Mahasiswa</th>
                            <th>Prodi</th>
                            <th>Status Mahasiswa</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($history as $item)
                            <tr class="text-center">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->mahasiswa->name }}</td>
                                <td>{{ $item->mahasiswa->programstudi->nama_prodi }}</td>
                                <td>{{ ucfirst($item->status) }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->changed_at)->format('d M Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
@endsection
