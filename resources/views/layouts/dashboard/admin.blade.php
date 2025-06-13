@extends('layouts.app')

@section('title', 'Dashboard LLDIKTI')

@section('content')
<div class="main-content">
    <section class="section" style="padding-bottom: 100px">
        <div class="section-header">
            <h1>Dashboard LLDIKTI</h1>
        </div>
        <div class="section-body">

            <form action="{{ route('dashboard.admin') }}" method="GET" class="row mb-4 align-items-end">
                <div class="col col-md-5">
                    <div class="form-group mb-0">
                        <label for="periodeFilter">Filter by Periode:</label>
                        <select id="periodeFilter" class="form-control" name="periode_id">
                            @foreach ($periodes as $item)
                                <option value="{{ $item->id }}" {{ $periode->id == $item->id ? 'selected' : '' }}>
                                    {{ $item->tahun }} {{ $item->semester }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary" style="min-width:120px;">Search</button>
                </div>
            </form>

            <div class="row mb-4 dashboard-row align-items-stretch">
                <!-- Card Perguruan Tinggi BESAR di kiri -->
                <div class="col-lg-3 col-md-12 mb-3 d-flex">
                    <div class="card card-primary card-dashboard card-pt flex-fill d-flex align-items-center justify-content-center">
                        <div class="card-body text-center d-flex flex-column justify-content-center align-items-center p-2 h-100">
                            <span class="card-title-dashboard">Perguruan Tinggi</span>
                            <span class="card-value-dashboard">{{ $totalPt }}</span>
                        </div>
                    </div>
                </div>
                <!-- Card kecil di kanan: 2 baris × 4 kolom -->
                <div class="col-lg-9 col-md-12">
                    <div class="row h-100">
                        <div class="col-lg-3 col-md-3 col-sm-6 col-12 mb-3">
                            <div class="card card-secondary card-dashboard h-100">
                                <div class="card-body text-center p-2 d-flex flex-column justify-content-center align-items-center h-100">
                                    <p class="mb-1 card-title-dashboard">Penetapan Awal Diajukan</p>
                                    <span class="card-value-dashboard">{{ number_format($totalPengajuanDiajukan) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-12 mb-3">
                            <div class="card card-success card-dashboard h-100">
                                <div class="card-body text-center p-2 d-flex flex-column justify-content-center align-items-center h-100">
                                    <p class="mb-1 card-title-dashboard">Pencairan Baru Diajukan</p>
                                    <span class="card-value-dashboard">{{ number_format($totalPencairanBaruDiajukan) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-12 mb-3">
                            <div class="card card-info card-dashboard h-100">
                                <div class="card-body text-center p-2 d-flex flex-column justify-content-center align-items-center h-100">
                                    <p class="mb-1 card-title-dashboard">Pencairan Ongoing Diajukan</p>
                                    <span class="card-value-dashboard">{{ number_format($totalPencairanOngoingDiajukan) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-12 mb-3">
                            <div class="card card-danger card-dashboard h-100">
                                <div class="card-body text-center p-2 d-flex flex-column justify-content-center align-items-center h-100">
                                    <p class="mb-1 card-title-dashboard">UKT/SPP Pencairan Baru</p>
                                    <span class="card-value-dashboard">Rp {{ number_format($totalUktSPPBaru, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-12 mb-3">
                            <div class="card card-secondary card-dashboard h-100">
                                <div class="card-body text-center p-2 d-flex flex-column justify-content-center align-items-center h-100">
                                    <p class="mb-1 card-title-dashboard">Penetapan Awal Disetujui</p>
                                    <span class="card-value-dashboard">{{ number_format($totalPengajuanDisetujui) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-12 mb-3">
                            <div class="card card-success card-dashboard h-100">
                                <div class="card-body text-center p-2 d-flex flex-column justify-content-center align-items-center h-100">
                                    <p class="mb-1 card-title-dashboard">Pencairan Baru Disetujui</p>
                                    <span class="card-value-dashboard">{{ number_format($totalPencairanBaruDisetujui) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-12 mb-3">
                            <div class="card card-info card-dashboard h-100">
                                <div class="card-body text-center p-2 d-flex flex-column justify-content-center align-items-center h-100">
                                    <p class="mb-1 card-title-dashboard">Pencairan Ongoing Disetujui</p>
                                    <span class="card-value-dashboard">{{ number_format($totalPencairanOngoingDisetujui) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-12 mb-3">
                            <div class="card card-danger card-dashboard h-100">
                                <div class="card-body text-center p-2 d-flex flex-column justify-content-center align-items-center h-100">
                                    <p class="mb-1 card-title-dashboard">UKT/SPP Pencairan Ongoing</p>
                                    <span class="card-value-dashboard">Rp {{ number_format($totalUktSPPOngoing, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Perguruan Tinggi -->
            <div class="container px-0">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama PT</th>
                                        <th>Penetapan Diajukan</th>
                                        <th>Penetapan Disetujui</th>
                                        <th>Pencairan Baru Diajukan</th>
                                        <th>Pencairan Baru Disetujui</th>
                                        <th>Pencairan Ongoing Diajukan</th>
                                        <th>Pencairan Ongoing Disetujui</th>
                                        <th>UKT/SPP Pencairan Baru</th>
                                        <th>UKT/SPP Pencairan Ongoing</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($perguruanTinggi->items() as $item)
                                        <tr>
                                            <td>{{ $perguruanTinggi->firstItem() + $loop->index }}</td>
                                            <td>{{ $item->nama_pt }}</td>
                                            <td>{{ $item->pengajuanDiajukan }}</td>
                                            <td>{{ $item->pengajuanDisetujui }}</td>
                                            <td>{{ $item->pencairanBaruDiajukan ?? '-' }}</td>
                                            <td>{{ $item->pencairanBaruDisetujui ?? '-' }}</td>
                                            <td>{{ $item->pencairanOngoingDiajukan ?? '-' }}</td>
                                            <td>{{ $item->pencairanOngoingDisetujui ?? '-' }}</td>
                                            <td>Rp {{ number_format($item->uktSppBaru ?? 0, 0, ',', '.') }}</td>
                                            <td>Rp {{ number_format($item->uktSppOngoing ?? 0, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $perguruanTinggi->links() }}
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Tabel Perguruan Tinggi -->

        </div>
    </section>
</div>

<style>
.dashboard-row {
    display: flex;
    align-items: stretch;
}
.card-dashboard {
    min-height: 90px !important;
    max-height: 130px;
    border-radius: 10px;
    margin-right: 1px;
    margin-bottom: 1px;
    box-shadow: 0 2px 8px 0 rgba(0,0,0,0.03);
    background: #fff;
}
.card-pt {
    min-height: 280px !important;
    height: 100%;
    font-size: 1.2rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
    background: #fff;
    box-shadow: 0 2px 8px 0 rgba(0,0,0,0.03);
}
.card-pt .card-title-dashboard {
    font-size: 1.2rem;
    font-weight: 600;
    color: #222;
    margin-bottom: 0.5rem;
    letter-spacing: 0.5px;
}
.card-pt .card-value-dashboard {
    font-size: 2.2rem;
    font-weight: 700;
    color: #222;
}
.card-title-dashboard {
    font-size: 0.8rem;
    margin-bottom: 0.25rem;
    color: #222;
    font-weight: 500;
}
.card-value-dashboard {
    font-size: 1.1rem;
    font-weight: 600;
    color: #222;
}
@media (max-width: 1199.98px) {
    .card-pt {
        min-height: 220px !important;
    }
    .card-pt .card-title-dashboard {
        font-size: 1.1rem;
    }
    .card-pt .card-value-dashboard {
        font-size: 2rem;
    }
}
@media (max-width: 991.98px) {
    .card-dashboard {
        min-height: 80px !important;
        max-height: 100px;
    }
    .card-pt {
        min-height: 140px !important;
    }
    .card-pt .card-title-dashboard {
        font-size: 1rem;
    }
    .card-pt .card-value-dashboard {
        font-size: 1.2rem;
    }
}
@media (max-width: 767.98px) {
    .dashboard-row {
        flex-direction: column;
    }
    .card-dashboard {
        min-height: 70px !important;
        max-height: 90px;
    }
    .card-title-dashboard {
        font-size: 0.95rem;
    }
    .card-value-dashboard {
        font-size: 1.1rem;
    }
    .card-pt {
        min-height: 100px !important;
    }
    .card-pt .card-title-dashboard {
        font-size: 0.95rem;
    }
    .card-pt .card-value-dashboard {
        font-size: 1.2rem;
    }
}
</style>
@endsection