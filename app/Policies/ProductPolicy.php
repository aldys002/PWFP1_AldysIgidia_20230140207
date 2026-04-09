<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    public function update(User $user, Product $product)
    {
        // Admin bisa edit semua, User cuma bisa edit miliknya sendiri
        return $user->role === 'admin' || $user->id === $product->user_id;
    }

    public function delete(User $user, Product $product)
    {
        // Admin bisa hapus semua, User cuma bisa hapus miliknya sendiri
        return $user->role === 'admin' || $user->id === $product->user_id;
    }
}