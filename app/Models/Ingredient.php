<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'tanggal_datang',
        'kuantitas',
        'satuan',
        'kadaluarsa',
        'foto',
        'status_kesegaran'
    ];

    public function kitchens()
    {
        return $this->belongsToMany(Kitchen::class, 'kitchen_ingredient')->withTimestamps();
    }
}
