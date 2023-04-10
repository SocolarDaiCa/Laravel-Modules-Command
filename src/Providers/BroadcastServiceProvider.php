<?php

namespace SocolaDaiCa\LaravelModulesCommand\Providers;

use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        require_once __DIR__.'/../../routes/channels.php';
    }
}
