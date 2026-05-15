<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kitchen extends Model
{
    protected $fillable = [
        'nama',
        'lokasi',
        'daftar_bahan'
    ];

}
