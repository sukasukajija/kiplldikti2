@extends('layouts.app')

@section('title', 'Edit Bank Mahasiswa')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Form Edit Bank Mahasiswa</h1>
        </div>

      <div class="card mt-3">
          <div class="card-header bg-primary text-white">
              <h4 class="text-white">Detail Mahasiswa</h4>
          </div>
          <div class="card-body">
              <table class="table table-bordered">
                  <tr>
                      <th width="30%">Nama Mahasiswa</th>
                      <td>{{ $mahasiswa->name }}</td>
                  </tr>
                  <tr>
                      <th>Perguruan Tinggi</th>
                      <td>{{ $mahasiswa->perguruantinggi->nama_pt }}</td>
                  </tr>
              </table>
          </div>
      </div>


      <form action="{{ route('pencairan.baru.edit_bank.store', ['mahasiswa_id' => $mahasiswa->id, 'periode_id' => $periode_id]) }}" method="POST">
          @csrf
          <div class="form-group">
              <label for="bank_id">Pilih Bank</label>
              <select name="bank_id" id="bank_id" class="form-control" required>
                  <option value="" disabled {{$mahasiswa->bank_id ? '' : 'selected'}}>Pilih Bank</option>
                  @foreach ($banks as $b)
                      <option value="{{ $b->id }}" {{ $mahasiswa->bank_id == $b->id ? 'selected' : '' }}>
                          {{ $b->name }}
                      </option>
                  @endforeach
              </select>
          </div>

         <div class="form-group">
             <label for="nama_rekening">Nama Rekening</label>
             <input type="text" name="nama_rekening_bank" id="nama_rekening_bank" class="form-control" value="{{ $mahasiswa->nama_rekening_bank }}" required>
         </div>
         
         <div class="form-group">
             <label for="no_rekening">No Rekening</label>
             <input type="text" name="no_rekening_bank" id="no_rekening_bank" class="form-control" value="{{ $mahasiswa->no_rekening_bank }}" required>
         </div>

          <button type="submit" class="btn btn-lg btn-success">Submit</button>
      </form>


    </section>
</div>
@endsection