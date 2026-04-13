<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Http\Requests\StoreProductRequest; // 1. Pastikan ini di-import
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {   
        $products = Product::with('user')->paginate(5);
        return view('product.index', compact('products'));
    }

    public function create()
    {
        $users = User::orderBy('name')->get();
        return view('product.create', compact('users'));
    }

    // 2. Ganti Request $request menjadi StoreProductRequest $request
    public function store(StoreProductRequest $request) 
    {
        // Validasi otomatis berjalan di sini sebelum masuk ke logic bawah
        $validated = $request->validated();
        
        // Tambahkan user_id otomatis dari siapa yang login
        $validated['user_id'] = Auth::id();

        Product::create($validated);

        return redirect()->route('product.index')->with('success', 'Product created successfully');
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('product.view', compact('product'));
    }

    public function edit(Product $product)
    {
        Gate::authorize('update', $product);
        $users = User::orderBy('name')->get();
        return view('product.edit', compact('product', 'users'));
    }

    // 3. Update juga fungsi update-nya
    public function update(StoreProductRequest $request, Product $product) 
    {
        Gate::authorize('update', $product);

        // Menggunakan data yang sudah divalidasi oleh Form Request
        $validated = $request->validated();

        $product->update($validated);

        return redirect()->route('product.index')->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product) 
    {
        Gate::authorize('delete', $product);
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Product berhasil dihapus');
    }
}