{{-- filepath: c:\xampp\htdocs\simkippp\resources\views\layouts\digitalisasi\pengajuan_admin\detail.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Pengajuan')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Detail Penetapan Awal</h1>
        </div>

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
                        <th>BA</th>
                        <td>
                            @if ($file->file_ba)
                            <a href="{{ asset('storage/' . $file->file_ba) }}" target="_blank">Lihat File
                                BA</a>
                            @else
                            <span class="badge bg-danger">Belum Upload</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>SK</th>
                        <td>
                            @if ($file->file_sk)
                            <a href="{{ asset('storage/' . $file->file_sk) }}" target="_blank">Lihat File SK</a>
                            @else
                            <span class="badge bg-danger">Belum Upload</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>SPTJM</th>
                        <td>
                            @if ($file->file_sptjm)
                            <a href="{{ asset('storage/' . $file->file_sptjm) }}" target="_blank">Lihat File
                                SPTJM</a>
                            @else
                            <span class="badge bg-danger">Belum Upload</span>
                            @endif
                        </td>
                    </tr>

                </table>
            </div>
        </div>

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
                            @if ($pengajuan->status == 'diajukan')
                            <span class="badge badge-secondary"><i class="fas fa-hourglass-half"></i> Diajukan</span>
                            @elseif ($pengajuan->status == 'disetujui')
                            <span class="badge badge-success"><i class="fas fa-check-circle"></i> Disetujui</span>
                            @else
                            <span class="badge badge-danger"><i class="fas fa-times-circle"></i> Ditolak</span>
                            @endif
                        </td>
                    </tr>
                    @if ($pengajuan->status == 'ditolak')
                    <tr>
                       <th>Keterangan Pengajuan Penolakan</th>
                       <td>{{ $pengajuan->remarks }}</td>
                     </tr>
                     @endif
                </table>
            </div>
        </div>

        <div class="text-right mt-3">
            <a href="{{ route('pengajuan_admin.approve', array_merge(['id' => $pengajuan->id], $queryParams ?? [])) }}" class="btn btn-success">Setujui</a>
            <a href="{{ route('pengajuan_admin.reject', array_merge(['id' => $pengajuan->id], $queryParams ?? [])) }}" class="btn btn-danger">Tolak</a>
            <a href="{{ route('pengajuan_admin.index', $queryParams ?? []) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </section>
</div>
@endsection