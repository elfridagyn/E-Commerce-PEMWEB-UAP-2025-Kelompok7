<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
    'code',
    'user_id',
    'product_id',
    'shipping_type_id',
    'address',
    'phone',
    'payment_method',
    'total_price',
    'status',
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

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }
    public function productReviews()
    {
        return $this->hasMany(ProductReview::class);
    }
}
