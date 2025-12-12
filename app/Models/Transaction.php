<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'code',
        'buyer_id', // ID Pembeli (FK ke users)
        'store_id', // ID Toko (FK ke stores)
        'address',
        'phone',
        'shipping_type_id', 
        'shipping_type', 
        'shipping_cost', 
        'tax', 
        'grand_total', 
        'subtotal', 
        'payment_method',
        'payment_status', 
        'status',
        // 'user_id' dihapus karena digantikan 'buyer_id' (untuk konsistensi)
    ];

    protected $casts = [
        'shipping_cost' => 'decimal:2',
        'tax' => 'decimal:2',
        'grand_total' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function buyer() // Menggunakan nama 'buyer' untuk FK ke users
    {
        return $this->belongsTo(\App\Models\User::class, 'buyer_id');
    }
    
    public function store()
    {
        return $this->belongsTo(\App\Models\Store::class);
    }
    
    public function shippingType() // Relasi baru
    {
        return $this->belongsTo(\App\Models\ShippingType::class, 'shipping_type_id');
    }

    public function transactionDetails()
    {
        return $this->hasMany(\App\Models\TransactionDetail::class);
    }
    
    public function productReviews()
    {
        return $this->hasMany(\App\Models\ProductReview::class);
    }
}