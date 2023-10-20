<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console;

use Illuminate\Console\Scheduling\Schedule;
use ReflectionException;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\CastMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\ChannelMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\CmsCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\ComponentMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\ConsoleMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\ControllerMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\EventMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\ExceptionMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\FacadeMakeCommand;
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
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\ModuleUpdateCommand;
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
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\ViewMakeCommand;

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
