@extends('layouts.app')

@section('title', 'Detail Pengajuan Ditolak')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Detail Pengajuan Ditolak</h1>
        </div>

        <form method="POST" enctype="multipart/form-data"
            action="{{ route('pengajuan_ditolak.pengajuanUlang', $pengajuan->id) }}">

            @csrf
            @method('POST')
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="text-white">Data Mahasiswa</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">NIM</th>
                            <td>{{ $pengajuan->mahasiswa->nim }}</td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td>{{ $pengajuan->mahasiswa->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $pengajuan->mahasiswa->email }}</td>
                        </tr>
                        <tr>
                            <th>SK</th>
                            <td class="d-flex justify-content-between align-items-center">
                                @if ($pengajuan->file_sk)
                                <a href="{{ asset('storage/' . $pengajuan->file_sk) }}" target="_blank">Lihat File
                                    SK</a>
                                @else
                                <span class="badge bg-danger">Belum Upload</span>
                                @endif

                                <input type="file" name="file_sk" accept="application/pdf" class="mt-2">
                            </td>
                        </tr>
                        <tr>
                            <th>SPTJM</th>
                            <td class="d-flex justify-content-between align-items-center">
                                @if ($pengajuan->file_sptjm)
                                <a href="{{ asset('storage/' . $pengajuan->file_sptjm) }}" target="_blank">Lihat File
                                    SPTJM</a>
                                @else
                                <span class="badge bg-danger">Belum Upload</span>
                                @endif

                                <input type="file" name="file_sptjm" accept="application/pdf" class="mt-2">
                            </td>
                        </tr>

                    </table>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success btn-lg ">Ajukan Ulang</button>
            </div>
        </form>

        <div class="card shadow-sm mt-3">
            <div class="card-header bg-info text-white">
                <h4 class="text-white">Detail Pengajuan</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">Periode</th>
                        <td>{{ $pengajuan->periode->tahun }} {{ $pengajuan->periode->semester }} </td>
                    </tr>
                    <tr>
                        <th>Tipe Pengajuan</th>
                        <td>{{ $pengajuan->tipePengajuan->tipe }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if ($pengajuan->status == 'pending')
                            <span class="badge badge-secondary"><i class="fas fa-hourglass-half"></i> Pending</span>
                            @elseif ($pengajuan->status == 'disetujui')
                            <span class="badge badge-success"><i class="fas fa-check-circle"></i> Disetujui</span>
                            @else
                            <span class="badge badge-danger"><i class="fas fa-times-circle"></i> Ditolak</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="text-right mt-3">
            <a href="{{ route('pengajuan_admin.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </section>
</div>
@endsection