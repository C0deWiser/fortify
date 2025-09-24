<?php

namespace Codewiser\Fortify;

use Illuminate\Support\ServiceProvider;

class AssetsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'fortify');
        $this->loadTranslationsFrom(__DIR__.'/../lang', 'fortify');

        $this->publishes([
            __DIR__.'/../lang' => $this->app->langPath(),
            __DIR__.'/../resources/views' => resource_path('views/auth'),
        ], 'fortify');

    }
}