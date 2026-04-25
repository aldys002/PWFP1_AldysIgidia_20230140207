<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider; // Tambahkan ini
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
{
    // Gate untuk tombol Export (Tugas Pertemuan 6)
    Gate::define('export-product', function (User $user) {
        return $user->role === 'admin';
    });

    // ✅ TAMBAHKAN INI: Gate untuk Menu Category (Tugas UCP 1)
    // Sesuai PDF: Membatasi akses menu Category hanya untuk Admin
    Gate::define('manage-category', function (User $user) {
        return $user->role === 'admin';
    });
}
}