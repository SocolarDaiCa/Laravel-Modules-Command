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
        $this->app->singleton(RepositoryInterface::class, function ($app) {
            $path = $app['config']->get('modules.paths.modules');

            return new LaravelFileRepository($app, $path);
        });

        $this->app->singleton(MigrationCreator::class, function ($app) {
            return new \SocolaDaiCa\LaravelModulesCommand\Overwrite\MigrationCreator(
                $app['files'],
                $app->basePath('stubs')
            );
        });
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

        $this->app->when(MigrationCreator::class)
            ->needs('$customStubPath')
            ->give(function ($app) {
                return $app->basePath('stubs');
            })
        ;

        $this->mergeConfigFrom(__DIR__.'/../../config/laravel-modules-command.php', 'laravel-modules-command');
        Helper::overwrireModulesConfig();

        $this->app->singleton(OpenPhpstorm::class);
    }
}
