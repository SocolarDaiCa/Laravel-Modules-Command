<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console;

use Illuminate\Console\Scheduling\Schedule;
use ReflectionException;

class Kernel extends \SocolaDaiCa\LaravelBadassium\Contracts\Console\Kernel
{
    /**
     * The Artisan commands provided by the application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

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
}
