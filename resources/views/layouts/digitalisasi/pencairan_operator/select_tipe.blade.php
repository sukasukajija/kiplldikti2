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
        <div class="container" style="margin-top: 20vh">

            <div class="row" style="margin-bottom: 80px">
                <div class="col-12 text-center">
                    <button class="btn btn-primary btn-lg" style="font-size: 24px; padding: 32px 48px;">
                        <a href="{{ route('pencairan.selectTipePencairan', ['periode_id' => $periode_id]) }}"
                            style="color: white; text-decoration: none">Pencairan - Mahasiswa Baru</a>
                    </button>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12 text-center">
                    <button class="btn btn-primary btn-lg" style="font-size: 24px; padding: 32px 48px;">
                        <a href="{{ route('evaluasi.upload-ba', ['periode_id' => $periode_id]) }}"
                            style="color: white; text-decoration: none">Pencairan - Mahasiswa Ongoing</a>
                    </button>
                </div>
            </div>
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