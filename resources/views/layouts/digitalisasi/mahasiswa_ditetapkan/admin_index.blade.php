@extends('layouts.app')

@section('title', 'Mahasiswa dengan Pengajuan Disetujui')

@section('content')
    <div class="main-content">
        <section class="section" style="padding-bottom: 100px">
            <div class="section-header">
                <h1>Mahasiswa Ditetapkan</h1>
            </div>

            <div class="section-body">
                <form action="{{ route('mahasiswa_ditetapkan.adminDitetapkan') }}" method="GET" style="display: flex; gap: 10px;">
                    <!-- Filter Perguruan Tinggi -->
                    <select name="perguruan_tinggi_id" class="form-control">
                        <option value="">Pilih Perguruan Tinggi</option>
                        @foreach ($perguruan_tinggi as $pt)
                            <option value="{{ $pt->id }}" {{ request('perguruan_tinggi_id') == $pt->id ? 'selected' : '' }}>
                                {{ $pt->nama_pt }}
                            </option>
                        @endforeach
                    </select>

                    <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan NIK..." value="{{ request('search') }}">

                    <button type="submit" class="btn btn-primary">Cari</button>
                    <a href="{{ route('mahasiswa_ditetapkan.adminDitetapkan') }}" class="btn btn-warning">Reset</a>
                </form>

                <div class="table-responsive mt-3">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th>#</th>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Program Studi</th>
                                <th>Perguruan Tinggi</th>
                                <th>SK</th>
                                <th>SPTJM</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pengajuan as $item)
                                <tr class="text-center">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->mahasiswa->nim }}</td>
                                    <td>{{ $item->mahasiswa->name }}</td>
                                    <td>{{ $item->mahasiswa->programstudi->nama_prodi }}</td>
                                    <td>{{ $item->mahasiswa->perguruantinggi->nama_pt }}</td>
                                    <td>
                                        <span class="badge {{ !empty($item->mahasiswa->file_sk) ? 'bg-success' : 'bg-danger' }}">
                                            {{ !empty($item->mahasiswa->file_sk) ? 'Sudah Upload' : 'Belum Upload' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge {{ !empty($item->mahasiswa->file_sptjm) ? 'bg-success' : 'bg-danger' }}">
                                            {{ !empty($item->mahasiswa->file_sptjm) ? 'Sudah Upload' : 'Belum Upload' }}
                                        </span>
                                    </td>
                                    <td><span class="badge badge-success">Disetujui</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
@endsection