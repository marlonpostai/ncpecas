<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Coloque aqui código de registro se necessário
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Log de consultas ao banco de dados
        DB::listen(function ($query) {
            Log::info($query->sql, $query->bindings);
        });
    }
}
