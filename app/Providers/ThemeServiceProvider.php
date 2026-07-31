<?php

namespace App\Providers;

use App\Services\ThemeManager;
use Illuminate\Support\ServiceProvider;

class ThemeServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ThemeManager::class, function ($app) {
            return new ThemeManager;
        });
    }

    public function boot(): void
    {
        //
    }
}
