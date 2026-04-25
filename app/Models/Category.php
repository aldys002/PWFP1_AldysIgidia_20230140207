<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    // Hanya 'name' yang ada di tabel category [cite: 28]
    protected $fillable = ['name'];

    // Satu kategori MEMILIKI BANYAK produk 
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}