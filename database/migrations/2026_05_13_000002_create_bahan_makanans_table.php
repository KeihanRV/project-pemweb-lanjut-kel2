<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('bahan_makanans')) {
            return;
        }

        if (Schema::hasTable('ingredients')) {
            $bahanMakanans = DB::table('bahan_makanans')->get();

            foreach ($bahanMakanans as $item) {
                $exists = DB::table('ingredients')
                    ->where('nama', $item->nama)
                    ->where('tanggal_datang', $item->tanggal_masuk)
                    ->where('kuantitas', $item->kuantitas)
                    ->where('satuan', $item->satuan)
                    ->exists();

                if (! $exists) {
                    DB::table('ingredients')->insert([
                        'nama' => $item->nama,
                        'tanggal_datang' => $item->tanggal_masuk,
                        'kadaluarsa' => $item->tanggal_masuk,
                        'kuantitas' => $item->kuantitas,
                        'satuan' => $item->satuan,
                        'foto' => $item->foto ?? '',
                        'status_kesegaran' => $item->status,
                        'created_at' => $item->created_at,
                        'updated_at' => $item->updated_at,
                    ]);
                }
            }
        }

        Schema::dropIfExists('bahan_makanans');
    }

    public function down(): void
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
};
