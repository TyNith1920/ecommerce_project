<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'name',
        'email',
        'phone',
        'rec_address',
        'quantity',
        'price',
        'payment_status',   // pending | paid | failed
        'status',           // in progress | completed | canceled
        'tran_id',          // ABA transaction ID
        'amount',           // numeric total (cart sum)
        'currency',         // USD / KHR
        'meta',             // gateway or debug info (JSON)
    ];

    protected $casts = [
        'meta'   => 'array',
        'amount' => 'decimal:2',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
