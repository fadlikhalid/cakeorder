<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    protected $fillable = ['size', 'price', 'cake_id']; // Include any other fillable attributes as needed

    // Define the inverse relationship with the Cake model
    public function cake()
    {
        return $this->belongsTo(Cake::class);
    }
}