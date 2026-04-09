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
        // Gate untuk tombol Export (Hanya Admin)
        // Sesuai tugas Kelas B
        Gate::define('export-product', function (User $user) {
            return $user->role === 'admin';
        });
    }
}