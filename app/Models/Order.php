<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'buyer_name',
        'buyer_phone',
        'buyer_address',
        'cake_id',
        'cake_type',
        'size_id',
        'cake_size',
        'price',
        'delivery_pickup_date',
        'delivery_pickup_time',
        'special_instructions',
        'remarks',
        'status'
    ];

    protected $casts = [
        'delivery_pickup_date' => 'date',
        'delivery_pickup_time' => 'datetime:H:i',
        'price' => 'decimal:2'
    ];

    public function cake()
    {
        return $this->belongsTo(Cake::class);
    }

    public function size()
    {
        return $this->belongsTo(CakeSize::class, 'size_id');
    }
}