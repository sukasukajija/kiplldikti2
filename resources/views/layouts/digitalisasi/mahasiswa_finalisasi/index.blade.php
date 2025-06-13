@extends('layouts.app')

@section('title', 'Mahasiswa Ditetapkan')

@section('content')
<div class="main-content">
    <section class="section" style="padding-bottom: 100px">
        <div class="section-header">
            <h1>Mahasiswa Ditetapkan</h1>
        </div>

        <div class="section-body">
            <form action="{{ route('mahasiswa_finalisasi_admin') }}" method="GET"
                style="display: flex; gap: 10px; margin-bottom: 20px;">
                <!-- Filter Perguruan Tinggi -->
                <select name="perguruan_tinggi_id" class="form-control">
                    <option value="">Pilih Perguruan Tinggi</option>
                    @foreach ($perguruan_tinggi as $pt)
                    <option value="{{ $pt->id }}" {{ request('perguruan_tinggi_id')==$pt->id ? 'selected' : '' }}>
                        {{ $pt->nama_pt }}
                    </option>
                    @endforeach
                </select>


                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('mahasiswa_finalisasi_admin') }}" class="btn btn-warning">Reset</a>
            </form>



            <a href="{{ route('mahasiswa.download-template-finalisasi') }}" class="btn btn-success">Download Template Excel</a>
            <form action="{{ route('mahasiswa.import-finalisasi') }}" method="POST" enctype="multipart/form-data" class="d-inline">
                @csrf
                <input type="file" name="file" accept=".xlsx, .xls" required>
                <button type="submit" class="btn btn-primary">Import Excel</button>
            </form>
            <div class="mb-3">
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th>PIN</th>
                        <th>NIM</th>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>GPA</th>
                        <th>Perguruan Tinggi</th>
                        <th>Program Studi</th>
                    </tr>
                </thead>
                <tbody>
                    @if($mahasiswa->isEmpty())
                    <tr>
                        <td colspan="9" class="text-center text-danger">
                            ❗ Tidak ada mahasiswa terdata di Finalisasi.
                        </td>
                    </tr>
                    @else
                    @foreach ($mahasiswa as $item)
                    <tr class="text-center">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->pin }}</td>
                        <td>{{ $item->nim }}</td>
                        <td>{{ $item->nik }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->gpa > 0 ? $item->gpa : "N/A" }}</td>
                        <td>{{ $item->perguruantinggi->nama_pt }}</td>
                        <td>{{ $item->programstudi->nama_prodi }}</td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>


        </div>
    </section>
</div>
@endsection