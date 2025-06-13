@extends('layouts.app')

@section('title', 'Data Mahasiswa')

@push('style')
<!-- CSS Libraries -->
@endpush

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Pengajuan Pencairan</h1>
        </div>
        @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif

        <div class="row">
            @foreach ($periode as $period)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h5>Periode {{ $period->tahun }}</h5>
                            <div>

                                @if($period->is_active)
                                <span class="badge badge-success">Dibuka</span>
                                @else
                                <span class="badge badge-secondary">Ditutup</span>
                                @endif

                            </div>
                        </div>
                        <h5>{{ $period->semester }}</h5>
                        <p>Pengajuan Penetapan KIP {{ $period->tahun }} {{ $period->semester }}<br>
                            Waktu: {{ $period->tanggal_dibuka }} - {{ $period->tanggal_ditutup }}</p>
                        <a href="{{ route('pencairan.selectTipePengajuan', ['periode_id' => $period->id]) }}"
                            class="btn btn-primary">
                            Mulai Pengajuan
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
</div>
@endsection

@push('scripts')
<!-- JS Libraries -->
@endpush

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
</script>
<!-- js untuk bootstrap4  -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous">
</script>
<!-- js untuk select2  -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>