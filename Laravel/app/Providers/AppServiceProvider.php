<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

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
        $this->configureRateLimiting();

        Route::group(['middleware' => 'api', 'prefix' => 'api'], function () { // **Correct Route::group() usage for API routes**
            require base_path('routes/api.php'); // **Load api.php routes within the group**
        });

        Route::middleware('web')->group(function () { // **Correct Route::group() usage for web routes**
            require base_path('routes/web.php'); // **Load web.php routes within the group**
        });
    }

    /**
     * Configure the rate limiting for the application.
     */
    protected function configureRateLimiting(): void
    {
        // Define your rate limiting logic here
    }
}