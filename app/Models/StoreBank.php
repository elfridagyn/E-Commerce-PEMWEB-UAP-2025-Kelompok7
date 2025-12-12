<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreBank extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'bank_name',
        'account_number',
        'account_owner',
    ];

    public function store() {
        return $this->belongsTo(Store::class);
    }
}
