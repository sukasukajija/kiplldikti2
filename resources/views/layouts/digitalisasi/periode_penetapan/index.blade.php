@extends('layouts.app')

@section('title', 'Data Periode Penetapan')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Periode Penetapan</h1>
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
                            <a href="{{ route('periode_penetapan.create') }}" class="btn btn-primary mb-3">Tambah Data</a>
                            <form action="{{ route('periode_penetapan.index') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Cari Berdasarkan Nama Klaster...">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" style="margin-left:5px;" type="submit">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6 d-flex justify-content-end">
                            <div class="form-group">
                                <label for="periode_id">Periode Dibuka</label>
                                <select id="periode_id" class="form-control">
                                   <option value="">-- Silakan Pilih Salah Satu --</option>
                                   @foreach($periode as $p)
                                     <option 
                                       value="{{ $p->id }}"
                                       {{ $p->is_active ? 'selected' : '' }}>
                                       {{ $p->tahun }} {{ $p->semester }}
                                     </option>
                                   @endforeach
                                 </select>
                            </div>
                        </div>
                    </div>



                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th>#</th>
                                <th>Periode</th>
                                <th>Tanggal Dibuka</th>
                                <th>Tanggal Ditutup</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($periode as $item)
                                <tr class="text-center">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->tahun }} {{ $item->semester }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_dibuka)->translatedFormat('j F Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_ditutup)->translatedFormat('j F Y') }}</td>

                                    <td>{{ $item->is_active ? 'Dibuka' : 'Ditutup' }}</td>
                                    
                                    <td>
                                        <a href="{{ route('periode_penetapan.edit', $item->id) }}" class="btn btn-primary">Edit</a>
                                        <form action="{{ route('periode_penetapan.delete', $item->id) }}" method="POST" class="delete-form" style="display: inline-block;">
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

                 $('#periode_id').on('change', function() {
                     const id = $(this).val();
                     if (!id) return;
                     window.location.href = `/periode_penetapan/set_active/${id}`;
                    }
                 );
            });
        </script>
