<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Nwidart\Modules\Facades\Module;
use SocolaDaiCa\LaravelAudit\Helper;
use SocolaDaiCa\LaravelBadassium\Contracts\Console\Command;
use Spatie\Once\Cache;
use function Laravel\Prompts\suggest;
use function Laravel\Prompts\text;

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

        $this->module = $this->choice(
            'Module?',
            $choices
        );

        $this->selectCommand();

        return $this->selectModule();
    }

    public function selectCommand()
    {
        $choices = [
            'back',
            'cms:make:model',
            'cms:make:controller',
            // 'cms:make:resource',
        ];

        $this->command = $this->choice(
            'Command?',
            $choices,
        );

        if ($this->command == 'back') {
            return null;
        }

        $parameters = match ($this->command) {
            'cms:make:model' => [
                '-m' => true,
                '-f' => true,
                '-s' => true,
            ],
            // 'cms:make:resource' => $this->makeResource(),
            'cms:make:controller' => [],
            default => null,
        };

        if ($parameters !== null) {
            Artisan::call($this->command, [
                ...$parameters,
                'module' => $this->module,
            ], $this->output);
        }

        return $this->selectCommand();
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
    }
}
