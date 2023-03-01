<?php

namespace SocolaDaiCa\LaravelModulesCommand\Providers;

use Illuminate\Database\Migrations\MigrationCreator;
use Illuminate\Support\ServiceProvider;
use Nwidart\Modules\Contracts\RepositoryInterface;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\CastMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\ChannelMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\ComponentMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\ConsoleMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\ControllerMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\EventMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\ExceptionMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\FactoryMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\HttpKernelMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\JobMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\ListenerMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\MailMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\MiddlewareMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\MigrateMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\ModelMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\ModuleMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\NotificationMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\ObserverMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\PolicyMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\ProviderMake1Command;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\ProviderMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\RequestMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\ResourceMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\RuleMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\SeederMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\StorageLinkCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\TestMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Helper;
use SocolaDaiCa\LaravelModulesCommand\Overwrite\LaravelFileRepository;

class LaravelModulesCommandServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(RepositoryInterface::class, function ($app) {
            $path = $app['config']->get('modules.paths.modules');

            return new LaravelFileRepository($app, $path);
        });
    }

    /**
     * Boot the application events.
     */
    public function boot()
    {
        $this->app->when(MigrationCreator::class)
            ->needs('$customStubPath')
            ->give(function ($app) {
                return $app->basePath('stubs');
            })
        ;

        $this->mergeConfigFrom(__DIR__.'/../../config/laravel-modules-command.php', 'laravel-modules-command');
        Helper::overwrireModulesConfig();
    }
}
