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
        Schema::create('eval_mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->integer('semester')->nullable();
            $table->decimal('gpa', 3, 2)->nullable();
            $table->unsignedBigInteger('mahasiswa_id')->nullable();
            $table->foreign('mahasiswa_id')->references('id')->on('mahasiswa')->onDelete('cascade');
            $table->unsignedBigInteger('periode_id')->nullable();
            $table->foreign('periode_id')->references('id')->on('periode_penetapan')->onDelete('cascade');
            $table->longText('file_transkrip')->nullable();
            $table->longText('file_ba')->nullable();
            $table->unsignedBigInteger('pendapatan_id')->nullable();
            $table->foreign('pendapatan_id')->references('id')->on('pendapatan_per_kapitas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eval_mahasiswas');
    }
};