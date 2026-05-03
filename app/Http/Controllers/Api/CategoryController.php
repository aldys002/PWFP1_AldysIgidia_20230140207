<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Menampilkan semua kategori.
     */
    public function index()
    {
        try {
            $categories = Category::all();
            return response()->json([
                'message' => 'Daftar kategori berhasil diambil',
                'data' => $categories
            ], 200);
        } catch (\Throwable $e) {
            Log::error('Gagal mengambil kategori: ' . $e->getMessage());
            return response()->json(['message' => 'Terjadi kesalahan server'], 500);
        }
    }

    /**
     * Menyimpan kategori baru.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:categories,name',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 400);
            }

            $category = Category::create($request->only('name'));

            Log::info('Kategori baru ditambahkan: ' . $category->name);

            return response()->json([
                'message' => 'Kategori berhasil dibuat!',
                'data' => $category
            ], 201);
        } catch (\Throwable $e) {
            Log::error('Error saat menambah kategori: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal menyimpan kategori'], 500);
        }
    }

    /**
     * Menampilkan detail satu kategori.
     */
    public function show($id)
    {
        try {
            $category = Category::find($id);

            if (!$category) {
                return response()->json(['message' => 'Kategori tidak ditemukan'], 404);
            }

            return response()->json([
                'data' => $category
            ], 200);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Terjadi kesalahan'], 500);
        }
    }

    /**
     * Memperbarui kategori.
     */
    public function update(Request $request, $id)
    {
        try {
            $category = Category::find($id);

            if (!$category) {
                return response()->json(['message' => 'Kategori tidak ditemukan'], 404);
            }

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:categories,name,' . $id,
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $category->update($request->only('name'));

            return response()->json([
                'message' => 'Kategori berhasil diperbarui',
                'data' => $category
            ], 200);
        } catch (\Throwable $e) {
            Log::error('Gagal update kategori: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal memperbarui kategori'], 500);
        }
    }

    /**
     * Menghapus kategori.
     */
    public function destroy($id)
    {
        try {
            $category = Category::find($id);

            if (!$category) {
                return response()->json(['message' => 'Kategori tidak ditemukan'], 404);
            }

            // Opsional: Cek apakah kategori masih dipakai oleh produk
            if ($category->products()->count() > 0) {
                return response()->json([
                    'message' => 'Kategori tidak bisa dihapus karena masih memiliki produk'
                ], 400);
            }

            $category->delete();

            return response()->json(['message' => 'Kategori berhasil dihapus'], 200);
        } catch (\Throwable $e) {
            Log::error('Gagal menghapus kategori: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal menghapus kategori'], 500);
        }
    }
}