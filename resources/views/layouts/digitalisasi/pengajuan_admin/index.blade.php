@extends('layouts.app')

@section('title', 'Data Pengajuan Mahasiswa')

@section('content')
<div class="main-content">
    <section class="section" style="padding-bottom: 100px">
        <div class="section-header">
            <h1>Daftar Pengajuan Penetapan Awal</h1>
        </div>

        @if (session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        <form action="{{ route('pengajuan_admin.index') }}" method="GET" style="display: flex; gap: 10px;">
            <!-- Filter Perguruan Tinggi -->
            <select name="perguruan_tinggi_id" class="form-control">
                <option value="">Pilih Perguruan Tinggi</option>
                @foreach ($perguruan_tinggi as $pt)
                <option value="{{ $pt->id }}" {{ request('perguruan_tinggi_id')==$pt->id ? 'selected' : '' }}>
                    {{ $pt->nama_pt }}
                </option>
                @endforeach
            </select>

            <!-- Filter Periode Penerimaan -->
            <select name="periode_id" class="form-control">
                <option value="">Pilih Periode Penerimaan</option>
                @foreach ($periode as $p)
                <option value="{{ $p->id }}" {{ request('periode_id')==$p->id ? 'selected' : '' }}>
                    {{ $p->tahun }} {{ $p->semester }}
                </option>
                @endforeach
            </select>

            <!-- Pencarian berdasarkan NIM -->
            <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan NIM..."
                value="{{ request('search') }}">

            <button type="submit" class="btn btn-primary">Cari</button>
            <a href="{{ route('pengajuan_admin.index') }}" class="btn btn-warning">Reset</a>
        </form>

        <div class="table-responsive mt-5">
            <div id="action-checkbox" class="d-none w-100 d-flex justify-content-end gap-1 my-3">
                <button type="button" class="btn btn-primary" id="export_data">
                    <i class="fas fa-file-export"></i> Export Data
                </button>
            </div>

            <table id="pengajuan-table" class="table table-bordered">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" name="select_all" id="select_all">
                        </th>
                        <th>#</th>
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th>Perguruan Tinggi</th>
                        <th>Prodi</th>
                        <th>Periode</th>
                        <th>Tipe Pengajuan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pengajuan as $item)
                    <tr class="text-center">
                        <td><input type="checkbox" value="{{ $item->id }}" {{ strtolower($item->status) !== "disetujui"
                            ? 'disabled' : '' }}>
                        </td>
                        <td>
                            {{ ($pengajuan instanceof \Illuminate\Pagination\LengthAwarePaginator)
                            ? ($pengajuan->currentPage() - 1) * $pengajuan->perPage() + $loop->iteration
                            : $loop->iteration
                            }}
                        </td>
                        <td>{{ $item->mahasiswa->nim }}</td>
                        <td>{{ $item->mahasiswa->name }}</td>
                        <td>{{ $item->mahasiswa->perguruantinggi->nama_pt }}</td>
                        <td>{{ $item->mahasiswa->programstudi->nama_prodi }}</td>
                        <td>{{ $item->periode->tahun }} {{ $item->periode->semester }}</td>
                        <td>{{ $item->tipePengajuan->tipe }}</td>
                        <td>
                            @switch(strtolower($item->status))
                            @case('disetujui')
                            <span class="badge badge-success badge-sm">Disetujui</span>
                            @break
                            @case('diajukan')
                            <span class="badge badge-secondary badge-sm">Diajukan</span>
                            @break
                            @case('ditolak')
                            <span class="badge badge-danger badge-sm">Ditolak</span>
                            @break
                            @default
                            <span class="badge badge-secondary badge-sm">Tidak Diketahui</span>
                            @endswitch
                        </td>

<td>
    <div class="d-inline-flex gap-1">
        <a href="{{ route('pengajuan_admin.show', $item->id) }}" class="btn btn-info btn-sm" title="Detail">
            <i class="fas fa-eye"></i>
        </a>
        @if($item->status !== 'disetujui')
        <a href="{{ route('pengajuan_admin.approve', array_merge(['id' => $item->id], request()->only(['page', 'per_page', 'perguruan_tinggi_id', 'periode_id', 'search']))) }}"
            class="btn btn-success btn-sm" title="Setuju">
            <i class="fas fa-check"></i>
        </a>
        @endif
        @if($item->status !== 'ditolak')
        <a href="{{ route('pengajuan_admin.reject', array_merge(['id' => $item->id], request()->only(['page', 'per_page', 'perguruan_tinggi_id', 'periode_id', 'search']))) }}"
            class="btn btn-danger btn-sm" title="Tolak">
            <i class="fas fa-times"></i>
        </a>
        @endif
    </div>
</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Pagination & Per Page Dropdown --}}
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    {{ $pengajuan instanceof \Illuminate\Pagination\LengthAwarePaginator ? $pengajuan->withQueryString()->links() : '' }}
                </div>
                <div>
                    <form action="{{ route('pengajuan_admin.index') }}" method="GET" id="perPageForm">
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ===== FUNGSI LAMA: Checkbox & Export =====
        const selectAllCheckbox = document.getElementById('select_all');
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        const form = document.getElementById('form_delete');
        let pengajuans = [];

        // Select All Checkbox
        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('click', function() {
                checkboxes.forEach(function(checkbox) {
                    if (!checkbox.disabled) {
                        checkbox.checked = selectAllCheckbox.checked;
                    }
                });
            });
        }

        // Individual Checkbox Changes
        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                pengajuans = [];

                const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
                const actionCheckbox = document.getElementById('action-checkbox');
                if (actionCheckbox) {
                    if (anyChecked) {
                        actionCheckbox.classList.remove('d-none');
                    } else {
                        actionCheckbox.classList.add('d-none');
                    }
                }

                checkboxes.forEach(function(checkbox) {
                    if (checkbox.checked && isNaN(checkbox.value) === false) {
                        pengajuans.push(+checkbox.value);
                    }
                });
            });
        });

        // Export Data
        const exportButton = document.getElementById('export_data');
        if (exportButton) {
            exportButton.addEventListener('click', function() {
                var url = "{{ route('pengajuan_admin.export') }}?pengajuans[]=" + pengajuans.join("&pengajuans[]=");
                window.location.href = url;
            });
        }

        // ===== FUNGSI BARU: Pagination Stay & Dropdown Per Page =====

        // Pagination stay (kiri saja)
        document.querySelectorAll('.pagination a').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const url = this.getAttribute('href');
                window.location.href = url + '#pengajuan-table';
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
        if(window.location.hash === '#pengajuan-table') {
            const table = document.getElementById('pengajuan-table');
            if(table) {
                setTimeout(function() {
                    table.scrollIntoView({behavior: "auto", block: "start"});
                }, 10);
            }
        }
    });
</script>
@endpush
