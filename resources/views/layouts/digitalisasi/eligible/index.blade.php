@extends('layouts.app')

@section('title', 'Data Mahasiswa')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Pengajuan Mahasiswa Diterima</h1>
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

            <div class="section-body">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="d-flex">

                            <h5 style="margin-right: 20px; margin-top:5px;">Filter</h5>
                            <form style="width:100%; display:flex;" action="{{ route('eligible.index') }}" method="GET">
                            <select name="kode_pt" style="width: 20%; margin-right:15px; border: solid 1px blue;" id="kode_pt" class="form-control @error('kode_pt') is-invalid @enderror" name="kode_pt" required>
                                <option value="" style="text-align: center">Perguruan Tinggi</option>
                                @foreach ($perguruan_tinggi as $item)
                                <option  value="{{$item->kode_pt}}">{{$item->nama_pt}}</option>
                                @endforeach
                            </select>
                            <select name="id_tahun_penerimaan" style="width: 20%; margin-right:15px; border: solid 1px blue;" id="id_tahun" class="form-control @error('id_tahun') is-invalid @enderror" name="id_tahun" required>
                                <option value="" style="text-align: center">Kategori Tahun</option>
                                @foreach ($tahun as $item)
                                <option value="{{$item->id}}">{{$item->tahun}}</option>
                                @endforeach
                            </select>
                            <select name="pencairan" style="width: 20%; margin-right:15px; border: solid 1px blue;" id="id_tahun" class="form-control @error('id_tahun') is-invalid @enderror" name="id_tahun" required>
                                <option value="" style="text-align: center">Kategori Pencairan</option>
                                <option value="belum">Belum</option>
                                <option value="sudah">Sudah</option>
                            </select>
                            <button class="btn btn-primary" style="margin-right: 10px" type="submit">Cari</button>
                            <a href="/eligible" class="btn btn-warning">Reset</a>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <form action="{{ route('eligible.index') }}" method="GET">
                            <div class="input-group mt-3">
                                <input type="text" name="search" class="form-control" placeholder="Cari Berdasarkan NIK Mahasiswa...">
                                <div class="input-group-append">
                                    <button class="btn btn-primary ms-2" type="submit">Cari</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-responsive">


                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Status Pencairan</th>
                                    <th>No KIP</th>
                                    <th>Tahun</th>
                                    <th>NIK</th>
                                    <th>Penetapan</th>
                                    <th>Bank</th>
                                    <th>No Rekening</th>
                                    <th>NISN</th>
                                    <th>NPSN</th>
                                    <th>Email</th>
                                    <th>NIM</th>
                                    <th>Nama</th>
                                    <th>Program studi</th>
                                    <th>UKT SPP</th>
                                    <th>Perguruan tinggi</th>

                                    @if (Auth::user()->id_role == 2)
                                        <th>Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pengajuan as $item)
                                    <tr>
                                        <td>@if ($item->status_pencairan == null)
                                            Belum diterima
                                        @elseif($item->status_pencairan == 'belum')
                                            <a href="{{ route('pencairan.create', [$item->peserta->nik,$item->id_tahun_penerimaan]) }}" class="btn btn-warning">Cairkan</a>
                                        @else
                                        <a href="{{ route('pencairan.detail', [$item->peserta->nik,$item->id_tahun_penerimaan]) }}" class="btn btn-info">Lihat Pencairan</a>
                                        @endif</td>
                                        <td>{{ $item->no_kip }}</td>
                                        <td>{{ $item->Tahunpenerimaan->tahun }}</td>
                                        <td>{{ $item->peserta->nik }}</td>
                                        <td>@if ($item->id_seleksi == null)
                                            Belum
                                        @else
                                        {{ $item->seleksi->kategori_penetapan }}
                                        @endif</td>
                                        <td>{{ $item->peserta->bank }}</td>
                                        <td>{{ $item->peserta->no_rekening }}</td>
                                        <td>{{ $item->peserta->nisn }}</td>
                                        <td>{{ $item->peserta->npsn }}</td>
                                        <td>{{ $item->peserta->email }}</td>
                                        <td>{{ $item->peserta->nim }}</td>
                                        <td>{{ $item->peserta->nama_mahasiswa }}</td>
                                        <td>{{ $item->peserta->programstudi->nama }}</td>
                                        <td>{{ $item->peserta->programstudi->ukt_spp }}</td>
                                        <td>{{ $item->peserta->perguruantinggi->nama_pt }}</td>

                                            <td class="d-flex">
                                                <a style="height: 40px; margin-right:10px;" href="/pengajuan/detail/{{$item->peserta->nik}}/{{$item->id_tahun_penerimaan}}" class="btn btn-primary">Detail</a>
                                            </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
@endpush

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<!-- js untuk bootstrap4  -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns"
        crossorigin="anonymous"></script>
<!-- js untuk select2  -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

