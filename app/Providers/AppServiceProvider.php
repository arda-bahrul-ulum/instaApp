<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

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
        Vite::prefetch(concurrency: 3);
        Inertia::share('auth', function () {
            return [
                'user' => Auth::user(),
            ];
        });
        Inertia::share('flash', function () {
            return [
                'success' => session('success'),
                'error' => session('error'),
            ];
        });
    }
}
