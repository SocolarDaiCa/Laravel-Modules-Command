<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class GenCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:gen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Artisan::call('cms:make:command CastMakeCommand LaravelModulesCommand');
        Artisan::call('cms:make:command ChannelMakeCommand LaravelModulesCommand');
        Artisan::call('cms:make:command ComponentMakeCommand LaravelModulesCommand');
        Artisan::call('cms:make:command ControllerMakeCommand LaravelModulesCommand');
        Artisan::call('cms:make:command EventMakeCommand LaravelModulesCommand');
        Artisan::call('cms:make:command ExceptionMakeCommand LaravelModulesCommand');
        Artisan::call('cms:make:command FactoryMakeCommand LaravelModulesCommand');
        Artisan::call('cms:make:command JobMakeCommand LaravelModulesCommand');
        Artisan::call('cms:make:command ListenerMakeCommand LaravelModulesCommand');
        Artisan::call('cms:make:command MailMakeCommand LaravelModulesCommand');
        Artisan::call('cms:make:command MiddlewareMakeCommand LaravelModulesCommand');
        Artisan::call('cms:make:command MigrationMakeCommand LaravelModulesCommand');
        Artisan::call('cms:make:command ModelMakeCommand LaravelModulesCommand');
        Artisan::call('cms:make:command NotificationMakeCommand LaravelModulesCommand');
        Artisan::call('cms:make:command ObserverMakeCommand LaravelModulesCommand');
        Artisan::call('cms:make:command PolicyMakeCommand LaravelModulesCommand');
        Artisan::call('cms:make:command ProviderMakeCommand LaravelModulesCommand');
        Artisan::call('cms:make:command RequestMakeCommand LaravelModulesCommand');
        Artisan::call('cms:make:command ResourceMakeCommand LaravelModulesCommand');
        Artisan::call('cms:make:command RuleMakeCommand LaravelModulesCommand');
        Artisan::call('cms:make:command SeederMakeCommand LaravelModulesCommand');
        Artisan::call('cms:make:command TestMakeCommand LaravelModulesCommand');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['example', InputArgument::REQUIRED, 'An example argument.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}
