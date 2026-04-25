<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // ================= PROFILE =================
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ================= ABOUT =================
    Route::get('/about', [AboutController::class, 'index'])->name('about');

    // ================= PRODUCT =================
    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/product', [ProductController::class, 'store'])->name('product.store');
    
    // 🔥 PENTING: Pindahkan route Export ke ATAS route Show {id}
    // Agar Laravel tidak menganggap 'export' sebagai sebuah ID
    Route::get('/product/export', function () {
        return "Export berhasil (hanya admin)";
    })->middleware('can:export-product')->name('product.export');

    Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
    Route::get('/product/edit/{product}', [ProductController::class, 'edit'])->name('product.edit');
    
    // Gunakan {product} agar sinkron dengan Route Model Binding di Controller
    Route::put('/product/update/{product}', [ProductController::class, 'update'])->name('product.update');
    
    // Ubah ke destroy agar sesuai standar (opsional, tapi lebih konsisten)
    Route::delete('/product/delete/{product}', [ProductController::class, 'destroy'])->name('product.delete');

    Route::middleware('can:manage-category')->group(function () {
        Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
        Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
        Route::post('/category', [CategoryController::class, 'store'])->name('category.store');
        
        // Tambahkan jika butuh edit/delete kategori
        Route::get('/category/edit/{category}', [CategoryController::class, 'edit'])->name('category.edit');
        Route::put('/category/{category}', [CategoryController::class, 'update'])->name('category.update');
        Route::delete('/category/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');
    
    });
});

require __DIR__.'/auth.php';