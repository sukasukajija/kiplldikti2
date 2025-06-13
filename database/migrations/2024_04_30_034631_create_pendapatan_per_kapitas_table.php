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
        Schema::create('pendapatan_per_kapitas', function (Blueprint $table) {
            $table->id();
            $table->string('keterangan')->nullable();
            $table->bigInteger('max_pendapatan')->nullable();
            $table->bigInteger('min_pendapatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendapatan_per_kapitas');
    }
};
