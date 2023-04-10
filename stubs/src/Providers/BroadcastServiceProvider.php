<?php

namespace __MODULE_NAMESPACE__\__STUDLY_NAME__\Providers;

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
        require_once __DIR__.'/../../routes/channels.php';
    }
}
