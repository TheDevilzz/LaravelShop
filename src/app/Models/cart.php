<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cart extends Model
{
    protected $table = 'cart';
    protected $fillable = ['userID', 'ProductID', 'quantity'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductID');
    }
}
