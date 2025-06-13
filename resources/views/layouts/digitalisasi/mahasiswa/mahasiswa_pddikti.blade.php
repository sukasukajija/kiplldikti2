{{-- filepath: c:\xampp\htdocs\simkippp\resources\views\layouts\digitalisasi\mahasiswa\mahasiswa_pddikti.blade.php --}}
@extends('layouts.app')

@section('title', 'Mahasiswa Terdata PDDIKTI')

@section('content')
<div class="main-content">
    <section class="section" style="padding-bottom: 100px">
        <div class="section-header">
            <h1>Mahasiswa Terdata PDDIKTI</h1>
        </div>

        <div class="section-body">
            <form action="{{ route('mahasiswa-pddikti.index') }}" method="GET"
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

                <!-- Filter Status PDDIKTI -->
                <select name="status_pddikti" class="form-control">
                    <option value="">Semua Status</option>
                    <option value="terdata" {{ request('status_pddikti')=='terdata' ? 'selected' : '' }}>Terdata
                    </option>
                    <option value="tidak_terdata" {{ request('status_pddikti')=='tidak_terdata' ? 'selected' : '' }}>
                        Tidak Terdata</option>
                </select>

                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('mahasiswa-pddikti.index') }}" class="btn btn-warning">Reset</a>
            </form>

            <a href="{{ route('mahasiswa.download-template') }}" class="btn btn-success">Download Template Excel</a>
            <form action="{{ route('mahasiswa.import') }}" method="POST" enctype="multipart/form-data" class="d-inline">
                @csrf
                <input type="file" name="file" accept=".xlsx, .xls" required>
                <button type="submit" class="btn btn-primary">Import Excel</button>
            </form>
            <div class="mb-3"></div>
            <a id="mahasiswa-table"></a>
            <table id="mahasiswa-table" class="table table-bordered">
                <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>GPA</th>
                        <th>Perguruan Tinggi</th>
                        <th>Program Studi</th>
                        <th>Status PDDIKTI</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if($mahasiswa->isEmpty())
                    <tr>
                        <td colspan="9" class="text-center text-danger">
                            ❗ Tidak ada mahasiswa terdata di PDDIKTI.
                        </td>
                    </tr>
                    @else
                    @foreach ($mahasiswa as $item)
                    <tr class="text-center">
                        <td>
                            {{ ($mahasiswa instanceof \Illuminate\Pagination\LengthAwarePaginator)
                                ? ($mahasiswa->currentPage() - 1) * $mahasiswa->perPage() + $loop->iteration
                                : $loop->iteration
                            }}
                        </td>
                        <td>{{ $item->nim }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->gpa > 0 ? $item->gpa : "N/A" }}</td>
                        <td>{{ $item->perguruantinggi->nama_pt }}</td>
                        <td>{{ $item->programstudi->nama_prodi }}</td>
                        <td>
                            <span class="badge {{ $item->status_pddikti == 'terdata' ? 'bg-success' : 'bg-danger' }}">
                                {{ $item->status_pddikti == 'terdata' ? 'Terdata' : 'Tidak Terdata' }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('mahasiswa_pddikti.updateStatus', $item->id) }}" method="POST">
                                @csrf
                                <select name="status_pddikti" onchange="this.form.submit()" class="form-control">
                                    <option value="terdata" {{ $item->status_pddikti == 'terdata' ? 'selected' : '' }}>Terdata</option>
                                    <option value="tidak_terdata" {{ $item->status_pddikti == 'tidak_terdata' ? 'selected' : '' }}>Tidak Terdata</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
            {{-- Pagination & Per Page Dropdown --}}
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    {{ $mahasiswa instanceof \Illuminate\Pagination\LengthAwarePaginator ? $mahasiswa->withQueryString()->links() : '' }}
                </div>
                <div>
                    <form action="{{ route('mahasiswa-pddikti.index') }}" method="GET" id="perPageForm">
                        @foreach(request()->except('per_page', 'page') as $key => $val)
                            <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                        @endforeach
                        <label for="per_page" class="me-2">Tampilkan</label>
                        <select name="per_page" id="per_page" class="form-control d-inline-block w-auto">
                            @foreach([10, 25, 50, 100, 'all'] as $size)
                                <option value="{{ $size }}" {{ request('per_page', 10) == $size ? 'selected' : '' }}>
                                    {{ $size === 'all' ? 'Semua' : $size }}
                                </option>
                            @endforeach
                        </select>
                        <span class="ms-2">data per halaman</span>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Pagination stay (kiri saja)
        document.querySelectorAll('.pagination a').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const url = this.getAttribute('href');
                window.location.href = url + '#mahasiswa-table';
            });
        });

        // Dropdown per page (kanan) normal submit, tanpa hash
        const perPageSelect = document.getElementById('per_page');
        if (perPageSelect) {
            perPageSelect.addEventListener('change', function() {
                document.getElementById('perPageForm').submit();
            });
        }

        // Scroll langsung ke tabel jika ada hash (untuk pagination saja)
        if(window.location.hash === '#mahasiswa-table') {
            const table = document.getElementById('mahasiswa-table');
            if(table) {
                setTimeout(function() {
                    table.scrollIntoView({behavior: "auto", block: "start"});
                }, 10);
            }
        }
    });
</script>
@endpush