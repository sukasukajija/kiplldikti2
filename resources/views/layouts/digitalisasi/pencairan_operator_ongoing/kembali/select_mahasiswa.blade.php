@extends('layouts.app')

@section('title', 'Pengajuan Pencairan')

@section('content')
<div class="main-content" style="margin-bottom: 100px">
    <section class="section">
        <div class="section-header">
            <h1>Pengajuan Pencairan - Mahasiswa Ongoing</h1>
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
                                <td>: Penetapan Kembali</td>
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
                                <td>No. Rekening BRI PT</td>
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


        <div class="alert alert-warning" role="alert">
            <i class="fas fa-exclamation-triangle"></i>
            <strong>Perhatian:</strong> Daftar mahasiswa yang ditampilkan hanya mencakup mereka yang pengajuan pencairan
            awalnya telah disetujui oleh LLDIKTI di periode sebelumnya, berstatus semester 2 ke atas, sudah dievaluasi
            pada periode
            {{
            $periode->tahun }} {{ $periode->semester }}, terdaftar di bank {{ $bank->name }}, dan menerima jenis bantuan
            {{ $jenis_bantuan->name }}.

        </div>



        @if (! $periode->is_active)
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
                <form method="POST"
                    action="{{ route('pencairan.ongoing.penetapan-kembali.select-mahasiswa.post', ['periode_id' => $periode_id, 'bank_id' => $bank_id, 'jenis_bantuan_id' => $jenis_bantuan_id]) }}">
                    @csrf

                    <div class="mb-3">
                    </div>

                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th><input type="checkbox" id="select-all"></th>
                                <th>ID</th>
                                <th>Status</th>
                                <th>PIN</th>
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Bank</th>
                                <th>Program Studi</th>
                                <th>UKT/SPP</th>
                                <th>Skema Jenis Bantuan</th>
                                <th>Terdata PDDIKTI</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $mahasiswa as $item)
                            <tr class="text-center">
                                <td>
                                    @if ($item->bank  && $item->status_mahasiswa != 'nonaktif' && !count($item->pencairan))
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
                                <td>{{ $item->pin }}</td>
                                <td>{{ $item->nim }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->bank ? $item->bank->name : 'N/A' }}</td>
                                <td>
                                    @if ($item->programstudi)
                                    {{ $item->programstudi->nama_prodi }}
                                    @else
                                    N/A
                                    @endif
                                </td>
                                <td>{{ $item->ukt_spp ? 'Rp. ' . number_format($item->ukt_spp, 0, ',', '.') : 'N/A' }}
                                </td>
                                <td>{{ $item->skema_bantuan_pembiayaan ?? 'N/A' }}</td>
                                <td>
                                    @if ($item->status_pddikti == 'terdata')
                                    <span class="badge bg-success">Terdata</span>
                                    @else
                                    <span class="badge bg-danger">Tidak Terdata</span>
                                    @endif
                                </td>
                                <td>
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
        checkboxes.forEach(checkbox => {
            if (!checkbox.disabled) {
                checkbox.checked = this.checked;
            }
        });
    });
</script>
@endsection