@extends('layouts.app')

@section('title', 'Pengajuan Penetapan')

@section('content')
<div class="main-content" style="margin-bottom: 100px">
    <section class="section">
        <div class="section-header">
            <h1>Penetapan Awal</h1>
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
                                <td>Periode</td>
                                <td>: {{ $periode->tahun }} {{ $periode->semester }}</td>
                            </tr>
                            <tr>
                                <td>Waktu</td>
                                <td>: {{ $periode->tanggal_dibuka }} - {{ $periode->tanggal_ditutup }}</td>
                            </tr>
                            <tr>



                                <td>NO. Rekening BRI</td>
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
            <i class="fas fa-exclamation-triangle"></i> Perhatian: Hanya mahasiswa yang terdata di PDDIKTI
            yang dapat diajukan. Pastikan memilih mahasiswa yang terdata di PDDIKTI.
        </div>


        @if(!$periode->is_active)
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

                <a href="{{ route('mahasiswa.download-template') }}" class="mt-1 btn btn-success">Download Template
                    Excel</a>
                <form action="{{ route('mahasiswa.import') }}" method="POST" enctype="multipart/form-data"
                    class="d-inline">
                    @csrf
                    <input type="file" name="file" accept=".xlsx, .xls" required>
                    <input type="text" name="periode_id" value="{{ $periode->id }}" hidden>
                    <button type="submit" class="btn btn-primary">Import Excel</button>
                </form>
                <form action="{{ route('pengajuan_penetapan.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="periode_id" value="{{ $periode->id }}">
                    <div class="mb-3">
                    </div>

                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th><input type="checkbox" id="select-all"></th>
                                <th>Status Ditetapkan</th>
                                <th>ID</th>
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>GPA</th>
                                <th>Program Studi</th>
                                <th>Terdata PDDIKTI</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $mahasiswa as $item)
                            <tr class="text-center">
                                <td>
                                    @if ($item->status_pddikti == 'terdata' && $item->status_mahasiswa == 'aktif' &&
                                    $item->status_pengajuan !== 'diajukan')
                                    <input type="checkbox" name="mahasiswa_ids[]" value="{{ $item->id }}">
                                    @else
                                    <input type="checkbox" disabled>
                                    @endif
                                </td>
                                <td>
                                    @if(count($item->pengajuan) == 0)
                                    <span class="badge badge-secondary">Belum Diajukan</span>
                                    @elseif($item->pengajuan[0]->status == 'diajukan')
                                    <span class="badge badge-secondary">Sudah Diajukan</span>
                                    @elseif($item->pengajuan[0]->status == 'disetujui')
                                    <span class="badge badge-success">Disetujui</span>
                                    @else
                                    <span class="badge badge-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nim }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->gpa > 0 ? $item->gpa : 'N/A' }}</td>
                                <td>{{ $item->programstudi->nama_prodi }}</td>
                                <td>
                                    <span
                                        class="badge {{ $item->status_pddikti == 'terdata' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $item->status_pddikti == 'terdata' ? 'Terdata' : 'Tidak Terdata' }}
                                    </span>
                                </td>
                                <td><a href="{{ route('mahasiswa.edit', $item->id) }}" class="btn btn-info">Edit</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>





                    @if(count($mahasiswa) > 0 && $periode->is_active)
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary btn-lg">Ajukan Mahasiswa</button>
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