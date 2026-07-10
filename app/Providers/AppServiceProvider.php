<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

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
        // Le site utilise Bootstrap (pas Tailwind) : on force le style
        // de pagination Bootstrap partout pour éviter les icônes géantes
        // non stylées du thème par défaut de Laravel.
        Paginator::defaultView('pagination::bootstrap-5');
        Paginator::defaultSimpleView('pagination::simple-bootstrap-5');
    }
}