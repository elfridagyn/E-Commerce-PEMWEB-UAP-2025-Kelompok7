<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{

    protected $fillable = [
        'name',
        'about',
        'phone',
        'city',
        'address',
        'postal_code',
        'logo',
        'bank_name',
        'bank_account_number',
        'bank_account_name',
        'status',
        'user_id'
    ];

    // relationships one store has one owner (user)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function storeBalance()
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

    public function bank() {
    return $this->hasOne(StoreBank::class);
}
public function withdrawals()
{
    return $this->hasMany(Withdrawal::class);
}

}
