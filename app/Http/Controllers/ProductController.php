<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate; // Tambahkan ini

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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:25',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'user_id' => 'required|exists:users,id',
        ]);

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
        // Gunakan Gate::authorize untuk memanggil ProductPolicy@update
        Gate::authorize('update', $product);

        $users = User::orderBy('name')->get();
        return view('product.edit', compact('product', 'users'));
    }

    public function update(Request $request, Product $product) // Pakai Route Model Binding agar lebih simpel
    {
        // Gunakan Gate::authorize untuk memanggil ProductPolicy@update
        Gate::authorize('update', $product);

        $validated = $request->validate([
            'name' => 'required|string|max:25',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'user_id' => 'required|exists:users,id',
        ]);

        $product->update($validated);

        return redirect()->route('product.index')->with('success', 'Product updated successfully');
    }

    // Biasanya di Laravel fungsi hapus dinamakan 'destroy'
    public function destroy(Product $product) 
    {
        // Gunakan Gate::authorize untuk memanggil ProductPolicy@delete
        Gate::authorize('delete', $product);

        $product->delete();

        return redirect()->route('product.index')->with('success', 'Product berhasil dihapus');
    }
}