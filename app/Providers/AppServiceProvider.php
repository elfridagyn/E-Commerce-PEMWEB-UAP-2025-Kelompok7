<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Redirect;
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
        Redirect::macro('home', function () {
            $user = Auth::user();
            
            if (!$user) return '/login';
            
            if ($user->role === 'admin') {
                return '/admin/dashboard';
            }
            
            return '/user/dashboard';
        });
    }
}