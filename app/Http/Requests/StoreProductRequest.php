<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            // ✅ TAMBAHKAN INI: Validasi category_id (harus ada di tabel categories)
            'category_id' => 'required|exists:categories,id', 
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama produk wajib diisi.',
            'name.max' => 'Nama produk tidak boleh lebih dari 255 karakter.',
            // ✅ TAMBAHKAN INI
            'category_id.required' => 'Kategori produk wajib dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'quantity.required' => 'Jumlah (kuantitas) produk wajib diisi.',
            'quantity.integer' => 'Jumlah produk harus berupa angka bulat.',
            'quantity.min' => 'Jumlah produk tidak boleh negatif.',
            'price.required' => 'Harga produk wajib diisi.',
            'price.numeric' => 'Harga produk harus berupa angka yang valid.',
            'price.min' => 'Harga produk tidak boleh negatif.',
        ];
    }
}