<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pencairans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswa')->onDelete('cascade');
            $table->foreignId('operator_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('periode_id')->constrained('periode_penetapan')->onDelete('cascade');
            $table->longText('dokumen_penolakan')->nullable();
            $table->longText('dokumen_pendukung')->nullable();
            $table->enum('status', ['disetujui', 'diajukan','ditolak', 'dibatalkan'])->default('diajukan');
            $table->unsignedBigInteger('tipe_pengajuan_id')->nullable();
            $table->foreign('tipe_pengajuan_id')->references('id')->on('tipe_pengajuan')->onDelete('cascade');
            $table->enum('tipe_pencairan', ['ajukan', 'pembatalan', 'penetapan_kembali', 'kelulusan'])->default('penetapan_kembali');
            $table->longText('keterangan')->nullable();
            $table->string('no_sk')->nullable()->default(null);
            $table->date('tanggal_sk')->nullable();
            $table->longText('keterangan_penolakan')->nullable();
            $table->foreignId('alasan_pembatalan_id')->nullable()->constrained('alasan_pembatalans')->onDelete('cascade');
            $table->longText('file_lampiran')->nullable();
            $table->longText('file_sptjm')->nullable();
            $table->longText('file_sk')->nullable();
            $table->longText('file_ba')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pencairans');
    }
};