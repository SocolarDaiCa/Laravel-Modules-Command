<?php

namespace SocolaDaiCa\LaravelModulesCommand\Providers;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\ServiceProvider;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\CastMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\ChannelMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\ComponentMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\ConsoleMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\ControllerMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\EventMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\ExceptionMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\FactoryMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\JobMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\ListenerMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\MailMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\MiddlewareMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\MigrateMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\ModelMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\NotificationMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\ObserverMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\PolicyMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\ProviderMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\RequestMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\ResourceMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\RuleMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\SeederMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\TestMakeCommand;

class LaravelModulesCommandServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'LaravelModulesCommand';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'laravelmodulescommand';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->commands([
            CastMakeCommand::class,
            ChannelMakeCommand::class,
            ComponentMakeCommand::class,
            ConsoleMakeCommand::class,
            ControllerMakeCommand::class,
            EventMakeCommand::class,
            ExceptionMakeCommand::class,
            FactoryMakeCommand::class,
            JobMakeCommand::class,
            ListenerMakeCommand::class,
            MailMakeCommand::class,
            MiddlewareMakeCommand::class,
//            MigrateMakeCommand::class,
            ModelMakeCommand::class,
            NotificationMakeCommand::class,
            ObserverMakeCommand::class,
            PolicyMakeCommand::class,
            ProviderMakeCommand::class,
            RequestMakeCommand::class,
            ResourceMakeCommand::class,
            RuleMakeCommand::class,
            SeederMakeCommand::class,
            TestMakeCommand::class,
        ]);
    }
}
