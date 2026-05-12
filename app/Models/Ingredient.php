<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $fillable = [
        'nama',
        'tanggal_datang',
        'kuantitas',
        'satuan', //satuan kuanitas
        'kadaluarsa',
        'foto',
        "status_kesegaran"
    ];


}
