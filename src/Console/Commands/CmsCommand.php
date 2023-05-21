<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Nwidart\Modules\Facades\Module;
use SocolaDaiCa\LaravelAudit\Helper;
use Spatie\Once\Cache;
use function PHPUnit\Framework\matches;
use function Sodium\crypto_box_publickey_from_secretkey;

class CmsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms';

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
        Cache::disable();
        $this->selectModule();
    }

    public function selectModule()
    {
        /** @var \SocolaDaiCa\LaravelModulesCommand\Overwrite\Module $moduleTestRector */
        $modules = collect(\Nwidart\Modules\Facades\Module::all());
        $choices = $modules->map(function (\SocolaDaiCa\LaravelModulesCommand\Overwrite\Module $module) {
            return $module->getLowerName();
        })->values()->all();

        // $choices = array_merge(['exit'], $choices);

        $this->module = $this->choice(
            'Module?',
            $choices
        );

        // if ($this->module == 'exit') {
        //     return;
        // }

        $this->selectCommand();
        return $this->selectModule();
    }

    public function selectCommand()
    {
        $choices = [
            'back',
            'cms:make:model',
            'cms:make:resource',
        ];

        $this->command = $this->choice(
            'Command?',
            $choices,
        );

        match($this->command) {
            'cms:make:model' => $this->makeModel(),
            'cms:make:resource' => $this->makeResource(),
            default => null,
        };

        return $this->selectCommand();
    }

    public function makeModel()
    {
        $modelName = $this->ask("[{$this->command}] Model Name?");

        $this->line("model name: $modelName");

        Artisan::call(
            "$this->command {$modelName} {$this->module}",
            [
                'mfs',
            ],
            $this->output
        );
    }

    public function makeResource()
    {
        $models = Helper::getReflectionClassNameByParent(Model::class);
        $model = $this->choice(
            'Model?',
            $models->all(),
        );

        Artisan::call('cms:make:resource', [
            '--model' => $model,
            'module' => $this->module,
        ], $this->output);

        // $modelName = $this->ask("[{$this->command}] Model Name?");
    }
}
