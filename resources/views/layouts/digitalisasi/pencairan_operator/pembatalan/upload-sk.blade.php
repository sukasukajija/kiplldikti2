@extends('layouts.app')

@section('title', 'SK Pembatalan Pencairan')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Form Upload Dokumen</h1>
        </div>


      <form action="{{ route('pencairan.baru.pembatalan.upload.sk.store', ['periode_id' => $periode_id]) }}" method="POST" accept="application/pdf" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
              <label for="file_sk">Upload SK Pembatalan Pencairan</label>
              <input type="file" name="file_sk" id="file_sk" class="form-control" accept="application/pdf" required>
          </div>

          <div class="form-group">
              <label for="file_dokumen_pendukung">Upload Lampiran (PDF)</label>
              <input type="file" name="file_lampiran" id="file_dokumen_pendukung" class="form-control" accept="application/pdf" required>
          </div>

          <div class="form-group">
              <label for="nomer_sk">Nomor SK</label>
              <input type="text" name="no_sk" id="nomer_sk" class="form-control" required>
          </div>

          <div class="form-group">
              <label for="tanggal_sk">Tanggal SK</label>
              <input type="date" name="tanggal_sk" id="tanggal_sk" class="form-control" required>
          </div>

          <button type="submit" class="btn btn-lg btn-success">Submit</button>
      </form>


    </section>
</div>
@endsection