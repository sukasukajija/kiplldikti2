{{-- filepath: c:\xampp\htdocs\simkippp\resources\views\layouts\digitalisasi\pencairan_admin\detail.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Pengajuan')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Detail Pengajuan Pencairan</h1>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="text-white">Data Mahasiswa</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">NIM</th>
                        <td>{{ $pencairan->mahasiswa->nim }}</td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>{{ $pencairan->mahasiswa->name }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $pencairan->mahasiswa->email }}</td>
                    </tr>
                    <tr>

                    @if ($pencairan->file_ba)
                    <tr>
                        <th>BA Pencairan</th>
                        <td>
                            <a href="{{ asset('storage/' . $pencairan->file_ba) }}" target="_blank">Lihat File BA</a>
                        </td>
                    </tr>
                    @endif
                    @if ($pencairan->file_sk)
                    <tr>
                        <th>SK Pencairan</th>
                        <td>
                            <a href="{{ asset('storage/' . $pencairan->file_sk) }}" target="_blank">Lihat File SK</a>
                        </td>
                    </tr>
                    @endif
                    
                    @if ($pencairan->file_sptjm)
                    <tr>
                        <th>SPTJM Pencairan</th>
                        <td>
                            <a href="{{ asset('storage/' . $pencairan->file_sptjm) }}" target="_blank">Lihat File SPTJM</a>
                        </td>
                    </tr>
                    @endif

                    @if ($pencairan->file_lampiran)
                    <tr>
                        <th>File Lampiran</th>
                        <td>
                            <a href="{{ asset('storage/' . $pencairan->file_lampiran) }}" target="_blank">Lihat File Lampiran</a>
                        </td>
                    </tr>
                    @endif

                    @if ($pencairan->dokumen_penolakan)
                    <tr>
                        <th>Dokumen Penolakan</th>
                        <td>
                            <a href="{{ asset('storage/' . $pencairan->dokumen_penolakan) }}" target="_blank">Lihat Dokumen Penolakan</a>
                        </td>
                    </tr>
                    @endif

                    @if ($pencairan->dokumen_pendukung)
                    <tr>
                        <th>Dokumen Pendukung</th>
                        <td>
                            <a href="{{ asset('storage/' . $pencairan->dokumen_pendukung) }}" target="_blank">Lihat Dokumen Pendukung</a>
                        </td>
                    </tr>
                    @endif

                    @if ($pencairan->pengajuan_tipe_id == 2)
                    <tr>
                        <th>Transkrip</th>
                        <td>
                            @if (count($pencairan->mahasiswa->evaluasi))
                                <a href="{{ asset('storage/' . $pencairan->mahasiswa->evaluasi[0]->file_transkrip) }}" target="_blank">Lihat File Transkrip</a>
                            @else
                                <span class="badge bg-danger">Belum Upload</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Pendapatan/Bulan</th>
                        <td>
                            @if(count($pencairan->mahasiswa->evaluasi))
                                @php
                                    $eval = $pencairan->mahasiswa->evaluasi[0];
                                @endphp

                                @if($eval->pendapatan->max_pendapatan && $eval->pendapatan->min_pendapatan)
                                    {{ number_format($eval->pendapatan->min_pendapatan) }} - {{ number_format($eval->pendapatan->max_pendapatan) }}
                                @elseif($eval->pendapatan->max_pendapatan)
                                    > {{ number_format($eval->pendapatan->max_pendapatan) }}
                                @else
                                    < {{ number_format($eval->pendapatan->min_pendapatan) }}
                                @endif
                            @else
                                <span class="badge bg-danger">Belum Evaluasi</span>
                            @endif
                        </td>
                    </tr>
                    @endif

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
                        <td>{{ $pencairan->periode->tahun }} {{ $pencairan->periode->semester }} </td>
                    </tr>
                    <tr>
                        <th>Tipe Pengajuan</th>
                        <td>{{ $pencairan->tipe_pengajuan->tipe }} {{ $pencairan->tipe_pencairan }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if ($pencairan->status == 'diajukan')
                                <span class="badge badge-info"><i class="fas fa-hourglass-half me-2"></i>Diajukan</span>
                            @elseif ($pencairan->status == 'disetujui')
                                <span class="badge badge-success"><i class="fas fa-check-circle me-2"></i>Disetujui</span>
                            @else
                                <span class="badge badge-danger"><i class="fas fa-times-circle me-2"></i>{{ ucfirst($pencairan->status) }}</span>
                            @endif
                        </td>
                    </tr>
                    @if ($pencairan->keterangan_penolakan)
                    <tr>
                        <th>Keterangan Pencairan Penolakan ( Admin )</th>
                        <td>{{ $pencairan->keterangan_penolakan }}</td>
                    </tr>
                    @endif

                    @if ($pencairan->keterangan)
                    <tr>
                        <th>Keterangan Pencairan Pembatalan ( Operator )</th>
                        <td>{{ $pencairan->keterangan }}</td>
                    </tr>
                    @endif

                    @if($pencairan->alasan_pembatalan_id)
                    <tr>
                        <th>Alasan Pembatalan ( Operator )</th>
                        <td>{{ $pencairan->alasanPembatalan->keterangan }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>

        <div class="text-right mt-3">
            <a href="{{ route('pencairan_admin.approve', array_merge(['pencairan_id' => $pencairan->id], $queryParams ?? [])) }}" class="btn btn-success">Setujui</a>
            <a href="{{ route('pencairan_admin.reject', array_merge(['pencairan_id' => $pencairan->id], $queryParams ?? [])) }}" class="btn btn-danger">Tolak</a>
            <a href="{{ route('pencairan_admin.index', $queryParams ?? []) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </section>
</div>
@endsection