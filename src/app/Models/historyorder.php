<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class historyorder extends Model
{
    protected $table = 'historycart';
    protected $fillable = ['userID', 'Address', 'ProductList'];
}
