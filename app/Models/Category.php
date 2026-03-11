<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['product_id', 'name'];

    // Relasi balik ke Product (Opsional tapi disarankan)
    public function product() {
        return $this->belongsTo(Product::class);
    }
}
