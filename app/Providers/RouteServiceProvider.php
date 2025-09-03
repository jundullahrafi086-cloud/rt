<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
{
    RateLimiter::for('api', function (Request $request) {
        return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
    });

    $this->routes(function () {
        // arahkan ke resources/routes/api.php jika ada
        $apiPath = resource_path('routes/api.php');
        if (file_exists($apiPath)) {
            Route::middleware('api')
                ->prefix('api')
                ->group($apiPath);
        }

        // arahkan ke resources/routes/web.php jika ada; jika tidak, fallback ke routes/web.php
        $webPath = resource_path('routes/web.php');
        if (file_exists($webPath)) {
            Route::middleware('web')->group($webPath);
        } else {
            Route::middleware('web')->group(base_path('routes/web.php'));
        }
    });
}}
