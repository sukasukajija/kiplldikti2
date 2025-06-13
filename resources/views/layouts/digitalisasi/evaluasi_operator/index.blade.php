@extends('layouts.app')

@section('title', 'Evaluasi Mahasiswa')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Evaluasi Mahasiswa {{ Auth::user()->perguruantinggi->nama_pt }}</h1>
        </div>

        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif

        <div class="section-body">


            <div class="alert alert-warning" role="alert">
                <i class="fas fa-exclamation-triangle"></i> Perhatian: Mahasiswa yang muncul disini adalah mahasiswa
                yang sudah terdata sebagai mahasiswa ditetapkan dan sudah melakukan pengajuan pencairan awal dan
                disetujui pada periode sebelumnya.
            </div>


            <div class="mb-3">
                <form method="GET" action="{{ route('evaluasi.index', ['periode_id' => $periode_id]) }}">
                    <div class="d-flex gap-2">
                        <input type="text" name="nim" class="form-control" placeholder="Cari berdasarkan NIM..."
                            value="{{ request('nim') }}">
                        <select class="form-control" name="program_studi">
                            <option value="">Program Studi</option>
                            @foreach($program_studi as $ps)
                            <option value="{{ $ps->id }}" {{ request('program_studi')==$ps->id ? 'selected' : '' }}>
                                {{ $ps->nama_prodi }}
                            </option>
                            @endforeach
                        </select>

                        <button type="submit" class="btn btn-primary">Search</button>
                        <a href="{{ route('evaluasi.index', ['periode_id' => $periode_id]) }}"
                            class="btn btn-warning">Reset</a>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th>#</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Bank</th>
                            <th>Semester</th>
                            <th>Evaluasi</th>
                            <th>Program Studi</th>
                            <th>IPK</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if($mahasiswa->isEmpty())

                        <tr>
                            <td colspan="9" class="text-center text-danger">
                                ❗ Data tidak ditemukan.
                            </td>
                        </tr>

                        @endif


                        @foreach ($mahasiswa as $item)
                        <tr class="text-center">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nim }}</td>
                            <td>{{ $item->name }}</td>
                            <td>

                                @if($item->bank_id)
                                {{ $item->bank->name }}
                                @else
                                <span class="badge badge-danger">Belum diisi</span>
                                @endif

                            </td>
                            <td>
                                {{ $item->getSemesterPeriod($periode_id) ?? $item->semester }}
                            </td>
                            <td>

                                @if(count($item->evaluasi))
                                <span class="badge badge-success">Pernah diisi</span>
                                @else
                                <span class="badge badge-danger">Belum pernah diisi</span>
                                @endif
                            </td>
                            <td>{{ $item->programstudi->nama_prodi }}</td>
                            <td>
                                {{ number_format($item->getGpaForPeriod($periode_id) ?? $item->gpa, 2) }}
                            <td>
                                <a href="{{ route('evaluasi.create', [ 'periode_id' => $periode_id,'mahasiswa_id' => $item->id]) }}"
                                    class="btn btn-info my-auto">Lakukan Evaluasi</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{ $mahasiswa->links() }}
    </section>

    <div class="d-flex justify-content-end mt-3">
        <a href="{{ route('select_tipe_pencairan.ongoing', ['periode_id' => $periode_id]) }}" class="btn btn-primary"><i
                class="fas fa-arrow-right"></i> Next</a>
    </div>
</div>
@endsection