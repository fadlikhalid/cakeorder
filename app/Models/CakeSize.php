<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CakeSize extends Model
{
    protected $fillable = ['cake_id', 'size', 'price'];

    public function cake()
    {
        return $this->belongsTo(Cake::class);
    }
}

