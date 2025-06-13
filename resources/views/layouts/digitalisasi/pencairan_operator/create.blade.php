@extends('layouts.app')

@section('title', 'Pengajuan Pencairan')

@section('content')
<div class="main-content" style="margin-bottom: 100px">
    <section class="section">
        <div class="section-header">
            <h1>Pengajuan Pencairan</h1>
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
                                <td>Bank</td>
                                <td>: {{ $bank->name }}</td>
                            </tr>
                            <tr>
                                <td>Kategori</td>
                                <td>: {{ $tipe->tipe }}</td>
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

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="pengajuan-tab" data-toggle="tab" href="#pengajuan" role="tab">Mahasiswa
                    yang Dapat Diajukan</a>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link" id="diajukan-tab" data-toggle="tab" href="#diajukan" role="tab">Mahasiswa yang Sudah
                    Diajukan</a>
            </li> --}}
            {{-- <li class="nav-item">
                <a class="nav-link" id="dokumen-tab" data-toggle="tab" href="#dokumen" role="tab">Dokumen Pendukung</a>
            </li> --}}
        </ul>

        <div class="tab-content" id="myTabContent">

            <div class="tab-pane fade show active" id="pengajuan">
                @if($tipe->id === 1)

                @endif
                <form action="{{ route('pencairan-upload.store') }}" method="POST">
                    @csrf

                    <input type="hidden" name="tipe_pengajuan_id" value="{{ $tipe->id }}">
                    <input type="hidden" name="bank_id" value="{{ $bank->id }}">
                    <div class="mb-3">
                    </div>

                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th><input type="checkbox" id="select-all"></th>
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
                        @php
                        $mahasiswa = $tipe->id === 1 ? $mahasiswaBelumDiajukan : $mahasiswaDiajukan;
                        @endphp
                        <tbody>
                            @foreach ( $mahasiswa as $item)
                            <tr class="text-center">
                                <td>
                                    @if ($item->status_pddikti == 'terdata' && $item->gpa > 0)
                                    <input type="checkbox" name="mahasiswa_ids[]" value="{{ $item->id }}">
                                    @else
                                    <input type="checkbox" disabled>
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

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary btn-lg">Lakukan Pencairan Mahasiswa</button>
                    </div>
                </form>
            </div>



            {{-- <div class="tab-pane fade" id="diajukan">
                <table class="table table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th>ID</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>GPA</th>
                            <th>Program Studi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mahasiswaDiajukan as $item)
                        <tr class="text-center">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nim }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->gpa }}</td>
                            <td>{{ $item->programstudi->nama_prodi }}</td>
                            <td><a href="{{ route('mahasiswa.edit', $item->id) }}" class="btn btn-info">Edit</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> --}}
            {{-- <div class="tab-pane fade" id="dokumen" role="tabpanel">
                <table class="table table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th>SK</th>
                            <th>SPTJM</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-center">
                            <td>
                                <span
                                    class="badge {{ !empty($perguruantinggi->file_sk) ? 'bg-success' : 'bg-danger' }}">
                                    {{ !empty($perguruantinggi->file_sk) ? 'Sudah Upload' : 'Belum Upload' }}
                                </span>
                            </td>
                            <td>
                                <span
                                    class="badge {{ !empty($perguruantinggi->file_sptjm) ? 'bg-success' : 'bg-danger' }}">
                                    {{ !empty($perguruantinggi->file_sptjm) ? 'Sudah Upload' : 'Belum Upload' }}
                                </span>
                            </td>
                            <td><a href="{{ route('perguruan_tinggi.upload_dokumen', $perguruantinggi) }}"
                                    class="btn btn-info">Upload Dokumen</a></td>
                        </tr>
                    </tbody>
                </table>
            </div> --}}
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