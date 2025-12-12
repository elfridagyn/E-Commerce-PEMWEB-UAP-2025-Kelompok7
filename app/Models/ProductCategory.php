<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductCategory extends Model
{
    // Nama tabel di database (opsional jika sudah mengikuti konvensi 'product_categories')
    protected $table = 'product_categories';

    protected $fillable = [
        'store_id',
        'image',
        'name',
        'slug',
        'tagline',
        'description',
    ];

    /**
     * Relasi ke parent category (kategori induk).
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'parent_id', 'id');
    }

    /**
     * Relasi ke sub-categories (kategori anak).
     */
    public function children(): HasMany
    {
        return $this->hasMany(ProductCategory::class, 'parent_id', 'id');
    } 

    /**
     * Relasi ke produk.
     */
    public function products(): HasMany
    {
        // Asumsi kolom foreign key di tabel 'products' adalah 'product_category_id'
        // Jika kolomnya 'category_id', sesuaikan: $this->hasMany(Product::class, 'category_id');
        return $this->hasMany(Product::class, 'product_category_id');
    }

    /**
     * Relasi ke toko (Store) yang memiliki kategori ini.
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
    
    /**
     * Method untuk mendapatkan URL gambar (accessor).
     */
    // public function getImageUrlAttribute(): string
    // {
    //     return $this->image ? asset('storage/' . $this->image) : asset('path/to/default/image.jpg');
    // }
}