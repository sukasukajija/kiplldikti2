{{-- filepath: c:\xampp\htdocs\simkippp\resources\views\layouts\digitalisasi\mahasiswa_ditetapkan\opt_index.blade.php --}}
@extends('layouts.app')

@section('title', 'Mahasiswa Ditetapkan')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Mahasiswa Ditetapkan {{ Auth::user()->perguruantinggi->nama_pt }}</h1>
            </div>

            <div class="section-body">
                <div class="mb-3">
                    <form method="GET" action="{{ route('mahasiswa_ditetapkan.operatorDitetapkan') }}">
                        <div class="d-flex gap-2">
                            <select class="form-control" name="periode">
                                <option value="">Periode</option>
                                @foreach($periode as $p)
                                    <option value="{{ $p->id }}" {{ request('periode') == $p->id ? 'selected' : '' }}>
                                        {{ $p->tahun }}
                                    </option>
                                @endforeach
                            </select>
                            <select class="form-control" name="program_studi">
                                <option value="">Program Studi</option>
                                @foreach($program_studi as $ps)
                                    <option value="{{ $ps->id }}" {{ request('program_studi') == $ps->id ? 'selected' : '' }}>
                                        {{ $ps->nama_prodi }}
                                    </option>
                                @endforeach
                            </select>

                            <button type="submit" class="btn btn-primary">Search</button>
                            <a href="{{ route('mahasiswa_ditetapkan.operatorDitetapkan') }}" class="btn btn-warning">Reset</a>
                        </div>

                        <div class="mt-2">
                            <input type="text" name="search" class="form-control" placeholder="Cari Berdasarkan NIM..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary mt-1">Search</button>
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
                                <th>Program Studi</th>
                                <th>IPK</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pengajuan as $item)
                                <tr class="text-center">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->mahasiswa->nim }}</td>
                                    <td>{{ $item->mahasiswa->name }}</td>
                                    <td>{{ $item->mahasiswa->programstudi->nama_prodi }}</td>
                                    <td>{{ number_format($item->mahasiswa->gpa, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                </div>
            </div>
        </section>
    </div>
@endsection

{{-- @extends('layouts.app')

@section('title', 'Mahasiswa Ditetapkan')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Mahasiswa Ditetapkan {{ Auth::user()->perguruantinggi->nama_pt }}</h1>
            </div>

            <div class="section-body">
                <div class="mb-3">
                    <form method="GET" action="{{ route('mahasiswa_ditetapkan.operatorDitetapkan') }}">
                        <div class="d-flex gap-2">
                            <select class="form-control" name="periode">
                                <option value="">Periode</option>
                                @foreach($periode as $p)
                                    <option value="{{ $p->id }}" {{ request('periode') == $p->id ? 'selected' : '' }}>
                                        {{ $p->tahun }}
                                    </option>
                                @endforeach
                            </select>
                            <select class="form-control" name="program_studi">
                                <option value="">Program Studi</option>
                                @foreach($program_studi as $ps)
                                    <option value="{{ $ps->id }}" {{ request('program_studi') == $ps->id ? 'selected' : '' }}>
                                        {{ $ps->nama_prodi }}
                                    </option>
                                @endforeach
                            </select>

                            <button type="submit" class="btn btn-primary">Search</button>
                            <a href="{{ route('mahasiswa_ditetapkan.operatorDitetapkan') }}" class="btn btn-warning">Reset</a>
                        </div>

                        <div class="mt-2">
                            <input type="text" name="search" class="form-control" placeholder="Cari Berdasarkan NIM..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary mt-1">Search</button>
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
                                <th>Program Studi</th>
                                <th>IPK</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pengajuan as $item)
                                <tr class="text-center">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->mahasiswa->nim }}</td>
                                    <td>{{ $item->mahasiswa->name }}</td>
                                    <td>{{ $item->mahasiswa->programstudi->nama_prodi }}</td>
                                    <td>{{ number_format($item->mahasiswa->gpa, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{ $pengajuan->links() }}
        </section>
    </div>
@endsection
 --}}