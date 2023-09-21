<?php

namespace SocolaDaiCa\LaravelModulesCommand\Providers;

use Illuminate\Database\Migrations\MigrationCreator;
use Illuminate\Support\ServiceProvider;
use Nwidart\Modules\Contracts\RepositoryInterface;
use SocolaDaiCa\LaravelModulesCommand\Console\Kernel as ConsoleKernel;
use SocolaDaiCa\LaravelModulesCommand\Helper;
use SocolaDaiCa\LaravelModulesCommand\OpenPhpstorm;
use SocolaDaiCa\LaravelModulesCommand\Overwrite\LaravelFileRepository;

class LaravelModulesCommandServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/laravel-modules-command.php', 'laravel-modules-command');

        // $this->app->register(\Nwidart\Modules\LaravelModulesServiceProvider::class);
        $this->app->register(OverwriteLaravelModulesServiceProvider::class);
    }

    /**
     * Boot the application events.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->app->singleton(ConsoleKernel::class);
            $this->app->make(ConsoleKernel::class);
        }

        $this->app->singleton(OpenPhpstorm::class);
    }
}
