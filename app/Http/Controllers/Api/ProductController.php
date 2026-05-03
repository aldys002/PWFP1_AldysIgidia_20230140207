<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreProductRequest;

class ProductController extends Controller
{
    /**
     * Menampilkan semua data produk.
     */
    public function index()
    {
        try {
            $products = Product::with('category')->get();
            return response()->json([
                'message' => 'Daftar produk berhasil diambil',
                'data' => $products
            ], 200);
        } catch (\Throwable $e) {
            Log::error('Gagal mengambil daftar produk: ' . $e->getMessage());
            return response()->json(['message' => 'Terjadi kesalahan server'], 500);
        }
    }

    /**
     * Menyimpan produk baru (Hanya untuk User yang Login).
     */
    public function store(StoreProductRequest $request)
    {
        try {
            $validated = $request->validated();
            $validated['user_id'] = Auth::id(); // Mengambil ID dari token

            $product = Product::create($validated);

            Log::info('Produk baru ditambahkan', ['product_id' => $product->id]);

            return response()->json([
                'message' => 'Produk berhasil ditambahkan!!',
                'data' => $product,
            ], 201);
        } catch (\Throwable $e) {
            Log::error('Error saat menambah produk: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal menyimpan data'], 500);
        }
    }

    /**
     * Menampilkan detail satu produk.
     */
    public function show(int $id)
    {
        try {
            $product = Product::with('category')->find($id);

            if (!$product) {
                return response()->json(['message' => 'Product tidak ditemukan'], 404);
            }

            return response()->json([
                'message' => 'Detail produk ditemukan',
                'data' => $product
            ], 200);
        } catch (\Throwable $e) {
            Log::error('Gagal mengambil detail produk: ' . $e->getMessage());
            return response()->json(['message' => 'Terjadi kesalahan'], 500);
        }
    }

    /**
     * Memperbarui data produk.
     */
    public function update(Request $request, $id)
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return response()->json(['message' => 'Produk tidak ditemukan'], 404);
            }

            // Otorisasi: Hanya pemilik atau admin (Opsional sesuai kebijakanmu)
            $product->update($request->all());

            Log::info('Produk diperbarui', ['product_id' => $id]);

            return response()->json([
                'message' => 'Produk berhasil diperbarui',
                'data' => $product
            ], 200);
        } catch (\Throwable $e) {
            Log::error('Gagal update produk: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal memperbarui data'], 500);
        }
    }

    /**
     * Menghapus produk.
     */
    public function destroy($id)
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return response()->json(['message' => 'Produk tidak ditemukan'], 404);
            }

            $product->delete();

            Log::info('Produk dihapus', ['product_id' => $id]);

            return response()->json(['message' => 'Produk berhasil dihapus'], 200);
        } catch (\Throwable $e) {
            Log::error('Gagal menghapus produk: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal menghapus data'], 500);
        }
    }
}