<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Support\Str;
use Dedoc\Scramble\Scramble;
use Illuminate\Routing\Route;
use Dedoc\Scramble\Support\Generator\SecurityScheme; // Import yang benar

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
        // 1. Gate untuk tombol Export (Tugas Pertemuan 6)
        Gate::define('export-product', function (User $user) {
            return $user->role === 'admin';
        });

        // 2. Gate untuk Menu Category (Tugas UCP 1)
        Gate::define('manage-category', function (User $user) {
            return $user->role === 'admin';
        });

        // --- KONFIGURASI SCRAMBLE (API PERTEMUAN 9) ---

        Scramble::configure()
            ->routes(function (Route $route) {
                // Mendokumentasikan semua route yang diawali 'api/'
                return Str::startsWith($route->uri, 'api/');
            })
            ->afterOpenApiGenerated(function ($openApi) {
                // Menambahkan skema keamanan Bearer Token (Sanctum)
                $openApi->secure(
                    SecurityScheme::http('bearer')
                );
            });

        // 3. Gate untuk Akses Dokumentasi API
        Gate::define('viewApiDocs', function () {
            // Dibuat true agar kamu bisa akses di localhost tanpa kendala
            return true; 
        });
    }
}