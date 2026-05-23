<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    protected $table = 'storages';

    protected $fillable = [
        'ingredient_id',
        'kitchen_id',
    ];

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class, 'ingredient_id');
    }

    public function kitchen()
    {
        return $this->belongsTo(Kitchen::class, 'kitchen_id');
    }

}
