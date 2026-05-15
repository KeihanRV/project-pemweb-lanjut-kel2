<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BahanMakanan extends Model
{
    protected $table = 'bahan_makanans';

    protected $fillable = [
        'nama',
        'tanggal_masuk',
        'status',
        'kuantitas',
        'satuan',
        'foto',
    ];
}
