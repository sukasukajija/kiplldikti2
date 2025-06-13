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
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->string('pin')->nullable();
            $table->string('nik')->unique();
            $table->string('nim');
            $table->string('name');
            $table->string('email')->unique();
            $table->decimal('gpa', 3, 2)->nullable();
            $table->longText('alamat')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->foreignId('bank_id')->nullable()->constrained('banks')->onDelete('cascade');
            $table->string('no_rekening_bank')->nullable()->default(null);
            $table->string('nama_rekening_bank')->nullable()->default(null);
            $table->boolean('is_visible')->default(false);

            // $table->enum('status', ['baru', 'ongoing']);
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->foreignId('periode_id')->nullable()->constrained('periode_penetapan')->onDelete('cascade');
            $table->foreignId('jenis_bantuan_id')->nullable()->constrained('jenis_bantuans')->onDelete('cascade');
            $table->foreignId('pendapatan_id')->nullable()->constrained('pendapatan_per_kapitas')->onDelete('cascade');
            $table->foreignId('perguruan_tinggi_id')->constrained('perguruan_tinggi')->onDelete('cascade');
            $table->foreignId('program_studi_id')->constrained('program_studi')->onDelete('cascade');
            $table->enum('status_pengajuan',['diajukan','belumDiajukan'])->default('belumDiajukan');
            $table->enum('status_pencairan',['diajukan','belumDiajukan'])->default('belumDiajukan');
            $table->enum('status_mahasiswa',['aktif','nonaktif','cuti','lulus'])->default('aktif');
            $table->enum('status_pddikti', ['terdata', 'tidak_terdata'])->default('tidak_terdata');
            
            $table->date('tanggal_yudisium')->nullable();
            $table->string('no_pendaftaran')->nullable()->default(null);
            $table->string('no_kk')->nullable()->default(null);
            $table->string('nik_kepala_keluarga')->nullable()->default(null);
            $table->string('nisn')->nullable()->default(null);
            $table->string('status_dtks')->nullable()->default(null);
            $table->string('status_p3ke')->nullable()->default(null);
            $table->string('no_kip')->nullable()->default(null);
            $table->string('no_kks')->nullable()->default(null);
            $table->string('asal_sekolah')->nullable()->default(null);
            $table->string('kab_kota_sekolah')->nullable()->default(null);
            $table->string('provinsi_sekolah')->nullable()->default(null);
            $table->string('tempat_lahir')->nullable()->default(null);
            $table->string('no_handphone')->nullable()->default(null);
            $table->string('nama_ayah')->nullable()->default(null);
            $table->string('pekerjaan_ayah')->nullable()->default(null);
            $table->string('penghasilan_ayah')->nullable()->default(null);
            $table->string('status_ayah')->nullable()->default(null);
            $table->string('nama_ibu')->nullable()->default(null);
            $table->string('pekerjaan_ibu')->nullable()->default(null);
            $table->string('penghasilan_ibu')->nullable()->default(null);
            $table->string('status_ibu')->nullable()->default(null);
            $table->integer('jumlah_tanggungan')->nullable()->default(null);
            $table->string('kepemilikan_rumah')->nullable()->default(null);
            $table->string('tahun_perolehan')->nullable()->default(null);
            $table->string('sumber_listrik')->nullable()->default(null);
            $table->integer('luas_tanah')->nullable()->default(null);
            $table->integer('luas_bangunan')->nullable()->default(null);
            $table->string('sumber_air')->nullable()->default(null);
            $table->string('mck')->nullable()->default(null);
            $table->decimal('jarak_pusat_kota_km', 8, 2)->nullable()->default(null);
            $table->string('seleksi_penetapan')->nullable()->default(null);
            $table->string('ukt_spp')->nullable()->default(null);
            $table->integer('ranking_penetapan')->nullable()->default(null);
            $table->integer('semester')->nullable()->default(null);
            $table->string('skema_bantuan_pembiayaan')->nullable()->default(null);
            $table->text('prestasi')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswa');
    }
};