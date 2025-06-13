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
        Schema::create('periode_penetapan', function (Blueprint $table) {
            $table->id();
            $table->string('tahun');
            $table->enum('semester',['Ganjil','Genap']);
            $table->date('tanggal_dibuka');
            $table->date('tanggal_ditutup');
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periode_penetapan');
    }
};