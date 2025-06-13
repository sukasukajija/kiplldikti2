@extends('layouts.app')

@section('title', 'Pengajuan Kelulusan Pencairan')

@section('content')
<div class="main-content" style="margin-bottom: 100px">
    <section class="section">
        <div class="section-header">
            <h1>Pengajuan Kelulusan - Mahasiswa Ongoing</h1>
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
                                <td>: Kelulusan</td>
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

        @if(count($mahasiswa) > 0)
        <div class="text-right my-3">
            <button type="button" class="btn btn-primary" id="btn-export">
                <i class="fas fa-file-export"></i> Export Data Terpilih
            </button>
        </div>
        @endif

        <div class="alert alert-warning" role="alert">
            <i class="fas fa-exclamation-triangle"></i>
            <strong>Perhatian:</strong> Daftar ini hanya memuat mahasiswa yang telah ditetapkan, melakukan pengajuan
            pencairan awal dan pencairan ulang sebelum periode
            {{ $periode->tahun }} {{ $periode->semester }}, dan terdaftar pada skema
            jenis bantuan “{{ $jenis_bantuan->name }}”.
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

                <form method="POST"
                    action="{{ route('pencairan.ongoing.kelulusan.select-mahasiswa.post', ['periode_id' => $periode->id, 'jenis_bantuan_id' => $jenis_bantuan_id]) }}">
                    @csrf

                    <div class="w-full overflow-x-auto">
                        <table class="table table-bordered min-w-full">
                            <thead>
                                <tr class="text-center">
                                    <th><input type="checkbox" id="select-all"></th>
                                    <th>ID</th>
                                    <th>Status</th>
                                    <th>PIN</th>
                                    <th>NIM</th>
                                    <th>Nama</th>
                                    <th>Tanggal Yudisium</th>
                                    <th>Program Studi</th>
                                    <th>Skema Jenis Bantuan</th>
                                    <th>Terdata PDDIKTI</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($mahasiswa as $item)
                                <tr class="text-center">
                                    <td>
                                        @if ($item->bank && $item->status_mahasiswa != 'nonaktif' && !count($item->pencairan) && $item->tanggal_yudisium)
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
                                    <td>{{ $item->tanggal_yudisium? $item->tanggal_yudisium->format('d-m-Y') : 'N/A' }}</td>
                                    <td>
                                        @if ($item->programstudi)
                                        {{ $item->programstudi->nama_prodi }}
                                        @else
                                        N/A
                                        @endif
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
                                        <a href="{{ route('pencairan.ongoing.kelulusan.edit-tanggal-yudisium', ['periode_id' => $periode->id, 'jenis_bantuan_id' => $jenis_bantuan_id, 'mahasiswa_id' => $item->id]) }}"
                                            class="btn btn-primary btn-sm">Edit Yudisium</a>
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
                    </div>

                    @if ($periode->is_active)
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary btn-lg">Next</button>
                    </div>
                    @endif
                </form>
            </div>

        </div>
    </section>
</div>

<script>
    // Select all checkbox logic
    document.getElementById('select-all').addEventListener('change', function () {
        const checkboxes = document.querySelectorAll('input[name="mahasiswa_ids[]"]');
        checkboxes.forEach(checkbox => {
            if (!checkbox.disabled) {
                checkbox.checked = this.checked;
            }
        });
    });

    // Export selected mahasiswa
    document.getElementById('btn-export').addEventListener('click', function() {
        let selected = [];
        document.querySelectorAll('input[name="mahasiswa_ids[]"]:checked').forEach(function(cb) {
            if (!cb.disabled) {
                selected.push(cb.value);
            }
        });
        if(selected.length === 0) {
            alert('Pilih minimal satu mahasiswa yang akan diexport!');
            return;
        }
        // Bangun URL export dengan parameter mahasiswa terpilih
        let url = "{{ route('mahasiswa.export') }}?mahasiswa_ids[]=" + selected.join("&mahasiswa_ids[]=");
        window.location.href = url;
    });
</script>
@endsection