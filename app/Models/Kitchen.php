<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Kitchen extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'lokasi',
        'daftar_bahan',
        'code'
    ];

    protected $table = 'kitchens';

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'kitchen_ingredient')->withTimestamps();
    }

    protected static function booted()
    {
        static::creating(function ($kitchen) {
            $kitchen->code = strtoupper(Str::random(4));
        });
    }
}
