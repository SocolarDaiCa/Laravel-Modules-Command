<?php

namespace SocolaDaiCa\LaravelModulesCommand\Providers;

use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        require __DIR__.'/../../routes/channels.php';
    }
}
