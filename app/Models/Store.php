<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{

    protected $fillable = [
        'user_id',
        'store_name',
        'description',
        'phone',
        'address',
        'logo',
        'status',
    ];

    // relationships one store has one owner (user)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function storeBallance()
    {
        return $this->hasOne(StoreBalance::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
