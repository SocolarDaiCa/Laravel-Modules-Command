<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Nwidart\Modules\Facades\Module;
use function PHPUnit\Framework\matches;
use function Sodium\crypto_box_publickey_from_secretkey;

class MakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Help genrerate code';

    protected $module = '';
    protected $command = '';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->selectModule();
    }

    public function selectModule()
    {
        /** @var \SocolaDaiCa\LaravelModulesCommand\Overwrite\Module $moduleTestRector */
        $modules = collect(\Nwidart\Modules\Facades\Module::all());
        $choices = $modules->map(function (\SocolaDaiCa\LaravelModulesCommand\Overwrite\Module $module) {
            return $module->getLowerName();
        })->values()->all();
        // dd($modules);
        // $moduleTestRector = $modules;
        // dd($moduleTestRector->getLowerName());
        // dd($moduleTestRector);

        $choices = array_merge(['exit'], $choices);

        $this->module = $this->choice(
            'Module?',
            $choices
        );

        if ($this->module == 'exit') {
            return;
        }

        $this->selectCommand();
        $this->selectModule();
    }

    public function selectCommand()
    {
        $choices = [
            'back',
            'cms:make:model',
        ];

        $this->command = $this->choice(
            'Command?',
            $choices
        );

        if ($this->command == 'back') {
            return;
        }

        match($this->command) {
            'cms:make:model' => $this->makeModel(),
        };

        return $this->selectCommand();
    }

    public function makeModel()
    {
        $modelName = $this->ask('Model Name?');

        $this->line("model name: $modelName");

        Artisan::call(
            "$this->command {$modelName} {$this->module}",
            [
                // '-mfs',
            ],
            $this->output
        );
    }
}
