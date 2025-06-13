@extends('layouts.app')

@section('title', 'Data Klaster Wilayah')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Klaster Wilayah</h1>
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
                <div class="table-responsive">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <a href="{{ route('klaster_wilayah.create') }}" class="btn btn-primary mb-3">Tambah Data</a>
                            <form action="{{ route('klaster_wilayah.index') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Cari Berdasarkan Nama Klaster...">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" style="margin-left:5px;" type="submit">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>



                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th>ID Klaster</th>
                                <th>Nama Klaster</th>
                                <th>Biaya Hidup</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($klaster as $item)
                                <tr class="text-center">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama_klaster }}</td>
                                    <td>Rp. {{ number_format($item->biaya_hidup , 0, ',', '.')}}</td>

                                    <td>
                                        <a href="{{ route('klaster_wilayah.edit', $item->id) }}" class="btn btn-primary">Edit</a>
                                        <form action="{{ route('klaster_wilayah.delete', $item->id) }}" method="POST" class="delete-form" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    const deleteForms = document.querySelectorAll('.delete-form');
                                    deleteForms.forEach(function (form) {
                                        form.addEventListener('submit', function (event) {
                                            event.preventDefault(); // Prevent form from submitting
                                            const confirmed = confirm('Yakin ingin menghapus data ini?. Jika data ini di hapus, maka seluruh data yang berhubungan dengan data ini ikut terhapus juga seperti mahasiswa, prodi dan yang lainnya');
                                            if (confirmed) {
                                                form.submit(); // Submit the form if confirmed
                                            }
                                        });
                                    });
                                });
                            </script>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->

    <!-- Page Specific JS File -->
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
        <script>
            $(document).ready(function () {
                $("#kota").select2({
                    theme: 'bootstrap4',
                    placeholder: "Please Select"
                });

                $("#kota2").select2({
                    theme: 'bootstrap4',
                    placeholder: "Please Select"
                });
            });
        </script>
