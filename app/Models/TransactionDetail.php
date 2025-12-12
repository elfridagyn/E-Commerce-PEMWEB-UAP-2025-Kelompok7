<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $fillable = [
        'transaction_id',
        'product_id',
        'qty',
        'subtotal',
        'store_id',
        'seller_id', // Tambah: Kolom ini penting untuk riwayat penjual
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    public function store()
    {
        return $this->belongsTo(\App\Models\Store::class);
    }
    
    public function seller()
    {
        return $this->belongsTo(\App\Models\User::class, 'seller_id');
    }
}