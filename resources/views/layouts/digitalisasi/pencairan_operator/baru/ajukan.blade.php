@extends('layouts.app')

@section('title', 'Pengajuan Pencairan')

@section('content')
<div class="main-content" style="margin-bottom: 100px">
    <section class="section">
        <div class="section-header">
            <h1>Pengajuan Pencairan - Mahasiswa Baru</h1>
        </div>

        @if (session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5>Keterangan</h5>
                        <table class="table">
                            <tr>
                                <td>Kategori</td>
                                <td>: Ajukan Pencairan Baru</td>
                            </tr>
                            <tr>
                                <td>Perguruan Tinggi</td>
                                <td>: {{ $perguruantinggi->nama_pt }}</td>
                            </tr>
                            <tr>
                                <td>Waktu</td>
                                <td>: {{ $periode->tanggal_dibuka }} - {{ $periode->tanggal_ditutup }}</td>
                            </tr>
                            <tr>
                                <td>No. Rekening BRI</td>
                                <td>: {{ $perguruantinggi->no_rekening_bri }} </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5>Informasi Tambahan</h5>
                        <table class="table">
                            <tr>
                                <td>Jumlah Mahasiswa</td>
                                <td>: {{ $mahasiswaCount }}</td>
                            </tr>
                            <tr>
                                <td>Status Pengajuan</td>
                                <td>: <span class="btn btn-danger">{{ $pengajuanReject }} Ditolak </span> <span
                                        class="btn btn-success">{{ $pengajuanApproved }} Disetujui</span></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <div class="alert alert-warning my-2" role="alert">
            <i class="fas fa-exclamation-triangle"></i> Perhatian: Mahasiswa yang muncul disini adalah mahasiswa yang
            sudah terdata sebagai mahasiswa ditetapkan dan sudah mengisi nomor rekening.
            <br> Hanya mahasiswa yang sudah mengisi nomor rekening yang
            dapat diajukan untuk pencairan.
        </div>

        @if(! $periode->is_active)
        @include('partials.alert-periode-ditutup')
        @endif

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="pengajuan-tab" data-toggle="tab" href="#pengajuan" role="tab">Mahasiswa
                    yang Dapat Diajukan</a>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">

            <div class="tab-pane fade show active" id="pengajuan">
                <form method="POST" action="{{ route('pencairan.baru.ajukan.store', ['periode_id' => $periode->id]) }}">
                    @csrf

                    <div class="mb-3">
                    </div>

                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th><input type="checkbox" id="select-all"></th>
                                <th>ID</th>
                                <th>Status</th>
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Bank</th>
                                <th>No. Rekening</th>
                                <th>Nama Rekening</th>
                                <th>Program Studi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $mahasiswa as $item)
                            <tr class="text-center">
                                <td>
                                    @if ($item->bank && $item->status_mahasiswa != 'nonaktif' && !count($item->pencairan))
                                    <input type="checkbox" name="mahasiswa_ids[]" value="{{ $item->id }}">
                                    @else
                                    <input type="checkbox" disabled>
                                    @endif
                                </td>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if (count($item->pencairan))
                                    @if($item->pencairan[0]->status == 'diajukan')
                                    <span class="badge bg-secondary">Diajukan</span>
                                    @elseif($item->pencairan[0]->status == 'disetujui')
                                    <span class="badge bg-success">Disetujui</span>
                                    @elseif($item->pencairan[0]->status == 'ditolak')
                                    <span class="badge bg-danger">Ditolak</span>
                                    @elseif($item->pencairan[0]->status == 'dibatalkan')
                                    <span class="badge bg-danger">Dibatalkan</span>
                                    @endif
                                    @else
                                    <span class="badge bg-secondary">Belum Diajukan</span>
                                    @endif
                                </td>
                                <td>{{ $item->nim }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->bank ? $item->bank->name : 'N/A' }}</td>
                                <td>{{ $item->bank ? $item->no_rekening_bank : 'N/A' }}</td>
                                <td>{{ $item->bank ? $item->nama_rekening_bank : 'N/A' }}</td>
                                <td>
                                    @if ($item->programstudi)
                                    {{ $item->programstudi->nama_prodi }}
                                    @else
                                    N/A
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('pencairan.baru.edit_bank.store', ['mahasiswa_id' => $item->id, 'periode_id' => $periode->id]) }}"
                                        class="btn btn-info">Edit Bank</a>
                                    @if (count($item->pencairan) && ($item->pencairan[0]->status == 'dibatalkan' ||
                                    $item->pencairan[0]->status == 'ditolak'))

                                    <a href="{{ route('operator.detail_penolakan', ['id' => $item->pencairan[0]->id]) }}"
                                        target="_blank" class="btn btn-primary btn-sm">Detail Penolakan</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>



                    @if($periode->is_active)
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary btn-lg">Lakukan Pencairan Mahasiswa</button>
                    </div>
                    @endif
                </form>
            </div>

        </div>
    </section>
</div>

<script>
    document.getElementById('select-all').addEventListener('change', function () {
        const checkboxes = document.querySelectorAll('input[name="mahasiswa_ids[]"]');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    });
</script>
@endsection