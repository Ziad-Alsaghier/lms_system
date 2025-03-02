<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\ServiceProvider;

class ModelServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
         // Bind User model globally
         $this->app->bind('User', function () {
         return new User();
         });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
