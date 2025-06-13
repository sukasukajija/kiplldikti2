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
        Schema::create('periode_penetapan_perguruan_tinggis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('perguruan_tinggi_id');
            $table->foreign('perguruan_tinggi_id')->references('id')->on('perguruan_tinggi')->onDelete('cascade');
            $table->unsignedBigInteger('periode_penetapan_id');
            $table->foreign('periode_penetapan_id')->references('id')->on('periode_penetapan')->onDelete('cascade');
            $table->longText('file_ba')->nullable();
            $table->longText('file_sptjm')->nullable();
            $table->longText('file_sk')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periode_penetapan_perguruan_tinggis');
    }
};