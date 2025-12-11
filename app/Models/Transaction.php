<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
    'code',
    'user_id',
    'buyer_id',
    'store_id',
    'product_id',
    'address',
    'phone',
    'shipping_type',
    'shipping_cost',
    'tax',
    'grand_total',
    'payment_method',
    'payment_status',
];

    protected $casts = [
        'shipping_cost' => 'decimal:2',
        'tax' => 'decimal:2',
        'grand_total' => 'decimal:2',
    ];

    public function buyer()
    {
        return $this->belongsTo(Buyer::class);
    }
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
    // Relasi ke TransactionDetail
    public function details()
    {
        return $this->hasMany(TransactionDetail::class, 'transaction_id', 'id');
    }

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }
    public function productReviews()
    {
        return $this->hasMany(ProductReview::class);
    }
}
