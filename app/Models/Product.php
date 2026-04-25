<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    // Tambahkan category_id ke sini 
    protected $fillable = ['user_id', 'category_id', 'name', 'quantity', 'price'];

    // Relasi: Produk MILIK sebuah kategori [cite: 15, 63]
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}