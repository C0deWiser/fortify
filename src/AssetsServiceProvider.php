<?php

namespace Codewiser\Fortify;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AssetsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Blade::anonymousComponentPath(__DIR__.'/../resources/views/components');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'fortify');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        $this->publishes([
            __DIR__.'/../public'          => public_path('vendor/fortify'),
            __DIR__.'/../resources/views' => resource_path('views/vendor/fortify'),
        ], 'fortify');
    }
}