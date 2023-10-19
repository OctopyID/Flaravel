<?php

namespace Octopy\Flaravel;

use Illuminate\Support\ServiceProvider;

class FlaravelServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() : void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/cloudflare.php', 'cloudflare'
        );
    }
}