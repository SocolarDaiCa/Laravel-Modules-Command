<?php

namespace __MODULE_NAMESPACE__\__STUDLY_NAME__\Console;

use Illuminate\Console\Application as Artisan;
use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\Finder\Finder;

class Kernel
{
    public function __construct()
    {
        $this->commands();
        $this->registerCommands([
        ]);

        if (app()->runningInConsole()) {
            app()->booted(function () {
                $this->schedule(app(Schedule::class));
            });
        }
    }

    /**
     * Define the application's command schedule.
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @throws ReflectionException
     *
     * @return void
     */
    protected function commands()
    {
        // $this->load(__DIR__.'/Commands');

        require __DIR__.'/../../routes/console.php';
    }

    /**
     * Register all of the commands in the given directory.
     *
     * @param array|string $paths
     *
     * @throws ReflectionException
     *
     * @return void
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
