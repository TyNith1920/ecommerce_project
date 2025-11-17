<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'color',
        'size',
        'price',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    // 🧍‍♂️ ភ្ជាប់ទៅនឹង User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 📦 ភ្ជាប់ទៅនឹង Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // 💰 គណនាតម្លៃសរុបនៃជួរនេះ (useful for UI)
    public function getLineTotalAttribute()
    {
        return round($this->price * $this->quantity, 2);
    }
}
