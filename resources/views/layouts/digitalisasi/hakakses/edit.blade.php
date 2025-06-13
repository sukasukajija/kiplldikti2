@extends('layouts.app')

@section('title', 'Edit Data Hak Akses')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Data Hak Akses</h1>
        </div>
        <form action="{{ route('hakakses.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <Label>User</Label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" readonly>
                    <label for="name">Hak Akses</label>
                    <select id="role" class="form-control @error('role') is-invalid @enderror" name="role" required>
                        <option value="">Pilih Hak Akses</option>
                        <option value="superadmin" {{ $user->role == 'superadmin' ? 'selected' : '' }}>superadmin</option>
                        <option value="operator" {{ $user->role == 'operator' ? 'selected' : '' }}>Operator</option>
                    </select>
                    {{-- <input type="text" name="role" id="role" class="form-control" value="{{ $hakakses->role }}"> --}}
                </div>


                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </section>
</div>
@endsection
