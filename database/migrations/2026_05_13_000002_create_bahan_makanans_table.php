<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bahan_makanans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->date('tanggal_masuk');
            $table->string('status')->nullable();
            $table->integer('kuantitas');
            $table->string('satuan');
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bahan_makanans');
    }
};
