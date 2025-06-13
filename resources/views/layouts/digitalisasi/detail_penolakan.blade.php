@extends('layouts.app')

@section('title', 'Detail Penolakan Pencairan')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Detail Penolakan</h1>
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

                   {{-- <tr>
                        <th>BA</th>
                         <td>
                            @if ($pencairan->mahasiswa->perguruantinggi->file[0])
                            <a href="{{ asset('storage/' . $pencairan->mahasiswa->perguruantinggi->file[0]->file_ba) }}"
                                target="_blank">Lihat File
                                BA</a>
                            @else
                            <span class="badge bg-danger">Belum Upload</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>SK</th>
                        <td>
                            @if ($pencairan->mahasiswa->perguruantinggi->file[0])
                            <a href="{{ asset('storage/' . $pencairan->mahasiswa->perguruantinggi->file[0]->file_sk) }}"
                                target="_blank">Lihat File SK</a>
                            @else
                            <span class="badge bg-danger">Belum Upload</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>SPTJM</th>
                        <td>
                            @if ($pencairan->mahasiswa->perguruantinggi->file[0])
                            <a href="{{ asset('storage/' . $pencairan->mahasiswa->perguruantinggi->file[0]->file_sptjm) }}"
                                target="_blank">Lihat File
                                SPTJM</a>
                            @else
                            <span class="badge bg-danger">Belum Upload</span>
                            @endif
                        </td>
                    </tr>--}}



                    @if (
                    $pencairan->file_ba &&
                    $pencairan->tipe_pengajuan_id == 2 && 
                    in_array($pencairan->tipe_pencairan, ['penetapan_kembali', 'pembatalan', 'kelulusan'])
                    )
                    
                    <tr>
                        <th>BA Evaluasi</th>
                        <td>
                            <a href="{{ asset('storage/' . $pencairan->file_ba) }}" target="_blank">Lihat File BA</a>
                        </td>
                    </tr>
                    @endif
                    
                    @if ($pencairan->file_sk)
                    <tr>
                        <th>SK Pembatalan Pencairan</th>
                        <td>
                            <a href="{{ asset('storage/' . $pencairan->file_sk) }}" target="_blank">Lihat File SK</a>

                        </td>
                    </tr>
                    @endif
                    @if ($pencairan->file_sptjm)
                    <tr>
                        <th>SPTJM Pembatalan Pencairan</th>
                        <td>
                            <a href="{{ asset('storage/' . $pencairan->file_sptjm) }}" target="_blank">Lihat File
                                SPTJM</a>

                        </td>
                    </tr>
                    @endif



                    @if ($pencairan->file_lampiran)
                    <tr>
                        <th>File Lampiran</th>
                        <td>
                            <a href="{{ asset('storage/' . $pencairan->file_lampiran) }}" target="_blank">Lihat File
                                Lampiran</a>
                        </td>
                    </tr>
                    @endif

                    @if ($pencairan->dokumen_penolakan)
                    <tr>
                        <th>Dokumen Penolakan</th>
                        <td>
                            <a href="{{ asset('storage/' . $pencairan->dokumen_penolakan) }}" target="_blank">Lihat
                                Dokumen Penolakan</a>
                        </td>
                    </tr>
                    @endif

                    @if ($pencairan->dokumen_pendukung)
                    <tr>
                        <th>Dokumen Pendukung Pembatalan</th>
                        <td>
                            <a href="{{ asset('storage/' . $pencairan->dokumen_pendukung) }}" target="_blank">Lihat
                                Dokumen Pendukung</a>
                        </td>
                    </tr>
                    @endif


                    @if ($pencairan->pengajuan_tipe_id == 2)
                    <tr>
                        <th>Transkrip</th>
                        <td>
                            @if (count($pencairan->mahasiswa->evaluasi))
                            <a href="{{ asset('storage/' . $pencairan->mahasiswa->evaluasi[0]->file_transkrip) }}"
                                target="_blank">Lihat File
                                Transkrip</a>
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
                            {{ number_format($eval->pendapatan->min_pendapatan) }} - {{
                            number_format($eval->pendapatan->max_pendapatan) }}
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
                            <span class="badge badge-info"><i class="fas fa-hourglass-half"></i>Diajukan</span>
                            @elseif ($pencairan->status == 'disetujui')
                            <span class="badge badge-success"><i class="fas fa-check-circle"></i>Disetujui</span>
                            @else
                            <span class="badge badge-danger"><i class="fas fa-times-circle"></i> Ditolak</span>
                            @endif
                        </td>
                    </tr>

                    @if($pencairan->mahasiswa->tanggal_yudisium)
                    <tr>
                        <th>Tanggal Yudisium</th>
                        <td>{{ $pencairan->mahasiswa->tanggal_yudisium->format('d-m-Y') }}</td>
                    </tr>
                    @endif

                    @if ($pencairan->keterangan_penolakan)
                    <tr>
                        <th>Keterangan Pencairan Penolakan ( Admin )</th>
                        <td>{{ $pencairan->keterangan_penolakan }}</td>
                    </tr>
                    @endif

                    @if ($pencairan->keterangan)
                    <tr>
                        <th>Keterangan Pencairan Pembatalan ( Operator )</th>
                        <td>{{ $pencairan->keterangan_penolakan }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>


        <div class="card shadow-sm mt-3">
    <div class="card-header bg-info text-white">
        <h4 class="text-white">Upload Ulang Dokumen</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('operator.ajukan_ulang', ['id' => $pencairan->id]) }}" method="POST" accept="application/pdf" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Upload SK (PDF)</label>
                <input type="file" name="file_sk" class="form-control" accept="application/pdf" required>
            </div>
            <div class="form-group">
                <label>Upload SPTJM (PDF)</label>
                <input type="file" name="file_sptjm" class="form-control" accept="application/pdf" required>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary btn-lg">Upload & Ajukan Ulang</button>
            </div>
        </form>
    </div>
</div>

       {{-- <div class="text-right mt-3">
            <a href="{{ route('pengajuan_admin.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>--}}
    </section>
</div>
@endsection