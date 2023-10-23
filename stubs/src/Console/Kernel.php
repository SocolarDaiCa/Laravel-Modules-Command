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

class Kernel extends \SocolaDaiCa\LaravelBadassium\Contracts\Console\Kernel
{
    /**
     * The Artisan commands provided by the application.
     *
     * @var array
     */
    protected $commands = [];
    /**
     * Define the application's command schedule.
     *
     * @return void
     */
    protected function schedule(Schedule $schedule): void
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
    protected function commands(): void
    {
        // $this->load(__DIR__.'/Commands');
        require_once __DIR__.'/../../routes/console.php';
    }
}
