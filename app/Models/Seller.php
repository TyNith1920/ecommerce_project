<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    public function products()
{
    return $this->hasMany(Product::class);
}
}
