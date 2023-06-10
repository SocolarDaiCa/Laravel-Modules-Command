<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console;

use Illuminate\Console\Application as Artisan;
use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionException;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\CastMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\ChannelMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\CmsCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\ComponentMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\ConsoleMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\ControllerMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\EventMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\ExceptionMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\FactoryMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\HttpKernelMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\IdeHelperCommnad;
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
use Symfony\Component\Finder\Finder;

class Kernel
{
    public function __construct()
    {
        $this->commands();
        $this->registerCommands([
            /* custom */
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
            //            Migrations\StatusCommand::class,
            MigrateMakeCommand::class,
            ModelMakeCommand::class,
            ModuleMakeCommand::class,
            NotificationMakeCommand::class,
            ObserverMakeCommand::class,
            PolicyMakeCommand::class,
            ProviderMakeCommand::class,
            RequestMakeCommand::class,
            ResourceMakeCommand::class,
            RuleMakeCommand::class,
            //            SeedCommand::class,
            SeederMakeCommand::class,
            TestMakeCommand::class,
            /* new */
            HttpKernelMakeCommand::class,
            ProviderMake1Command::class,
            StorageLinkCommand::class,
            CmsCommand::class,
            IdeHelperCommnad::class,
        ]);

        if (app()->runningInConsole()) {
            app()->booted(function () {
                $this->schedule(app(Schedule::class));
            });
        }
    }

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @throws ReflectionException
     */
    protected function commands()
    {
        // $this->load(__DIR__.'/Commands');

        require_once __DIR__.'/../../routes/console.php';
    }

    /**
     * Register all of the commands in the given directory.
     *
     * @param array|string $paths
     *
     * @throws ReflectionException
     */
    protected function load($paths)
    {
        $paths = array_unique(Arr::wrap($paths));

        $paths = array_filter($paths, function ($path) {
            return is_dir($path);
        });

        if (empty($paths)) {
            return;
        }

        $namespace = Str::before(static::class, '\Kernel');

        foreach ((new Finder())->in($paths)->files() as $command) {
            $command = $namespace.str_replace(
                ['/', '.php'],
                ['\\', ''],
                Str::after($command->getRealPath(), __DIR__)
            );

            if (is_subclass_of($command, Command::class) && !(new ReflectionClass($command))->isAbstract()) {
                Artisan::starting(function ($artisan) use ($command) {
                    $artisan->resolve($command);
                });
            }
        }
    }

    public function registerCommands($commands)
    {
        Artisan::starting(function (Artisan $artisan) use ($commands) {
            $artisan->resolveCommands($commands);
        });
    }
}
