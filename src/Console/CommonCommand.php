<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console;

use Illuminate\Support\Str;
use Nwidart\Modules\Facades\Module;
use SocolaDaiCa\LaravelBadassium\Helpers\PromptsAble;
use SocolaDaiCa\LaravelModulesCommand\Facades\OpenPhpstorm;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

trait CommonCommand
{
    use PromptsAble;

    /**
     * @var \Nwidart\Modules\Laravel\Module
     */
    protected $module;

    public function __construct()
    {
        if (!empty($this->getName())) {
            $this->setName('cms:'.$this->getName());
        }

        if (!empty($this->signature)) {
            $this->signature = 'cms:'.$this->signature.' {module}';
        }

        parent::__construct();
    }

    public function getModule(): \Nwidart\Modules\Laravel\Module
    {
        if ($this->module == null) {
            $this->module = Module::find(Str::camel($this->argument('module')));
        }

        return $this->module;
    }

    public function getGeneratorFolder($key)
    {
        return $this->getModule()->getPath()
            .'/'
            .$this->laravel['config']['modules']['paths']['generator'][$key]['path'];
    }

    public function getGeneratorPath($key, $name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return $this->getGeneratorFolder($key)
            .'/'
            .str_replace('\\', '/', $name)
            .'.php';
    }

    public function getGeneratorNamespace($key)
    {
        $namespace = $this->rootNamespace().$this->laravel['config']['modules']['paths']['generator'][$key]['namespace'];

        return str_replace('/', '\\', $namespace);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['module', InputArgument::REQUIRED, 'The name of module will be used.'],
            ...parent::getArguments(),
        ];
    }

    /**
     * Run the given the console command.
     *
     * @param string|\Symfony\Component\Console\Command\Command $command
     *
     * @return int
     */
    protected function runCommand($command, array $arguments, OutputInterface $output)
    {
        $command = 'cms:'.$command.' '.$this->argument('module');

        return parent::runCommand($command, $arguments, $output);
    }

    protected function promptForMissingArgumentsUsing()
    {
        $prompts = parent::promptForMissingArgumentsUsing();

        if (!empty($prompts['name'])) {
            $prompts['name'] = match ($this->type) {
                'Model' => fn () => $this->anticipate(
                    $prompts['name'][0],
                    fn ($input) => collect([
                        'Admin',
                        'User',
                        'Role',
                        'Permission',
                        'Post',
                    ])
                        ->filter(fn ($item) => $item != $input)
                        ->filter(fn ($item) => Str::startsWith($item, $input))
                        ->toArray(),
                ),
                // todo: make:command auto complete
                default => $prompts['name'],
            };
        }

        return $prompts;
    }

    public function handle()
    {
        $result = parent::handle();

        OpenPhpstorm::openAll();

        return $result;
    }
}
