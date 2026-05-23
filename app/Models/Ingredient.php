<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $attributes = [
        'status_kesegaran' => 'Unknown',
    ];

    // Status kesegaran hanya berasal dari hasil inferensi ML.
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

    public function storages()
    {
        return $this->hasMany(Storage::class, 'ingredient_id');
    }

    public function setStatusKesegaranAttribute(?string $value): void
    {
        $normalized = strtolower(trim($value ?? ''));

        $this->attributes['status_kesegaran'] = match ($normalized) {
            'segar' => 'Segar',
            'busuk', 'tidak segar' => 'Busuk',
            'unknown', 'tidak diketahui' => 'Unknown',
            default => 'Unknown',
        };
    }

    public function getStatusKesegaranAttribute(?string $value): string
    {
        return match (strtolower(trim($value ?? ''))) {
            'segar' => 'Segar',
            'busuk', 'tidak segar' => 'Busuk',
            'unknown', 'tidak diketahui' => 'Unknown',
            default => 'Unknown',
        };
    }
}
