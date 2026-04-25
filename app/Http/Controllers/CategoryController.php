<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // Mengambil kategori dengan jumlah produk yang berelasi 
        $categories = Category::withCount('products')->get();
        
        return view('category.index', compact('categories'));
    }

    public function create()
    {
        return view('category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name'
        ]);

        Category::create($request->all());

        return redirect()->route('category.index')->with('success', 'Category created successfully!');
    }
}