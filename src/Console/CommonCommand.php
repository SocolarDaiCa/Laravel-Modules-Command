<?php
namespace SocolaDaiCa\LaravelModulesCommand\Console;

use Illuminate\Support\Str;
use Nwidart\Modules\Facades\Module;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

trait CommonCommand
{
    public function __construct()
    {
        if (!empty($this->getName())) {
            $this->setName('cms:' . $this->getName());
        }

        if (!empty($this->signature)) {
            $this->signature = 'cms:' . $this->signature . ' {module}';
        }

        parent::__construct();
    }

    /**
     * @var \Nwidart\Modules\Laravel\Module
     */
    protected $module = null;

    /**
     * @return \Nwidart\Modules\Laravel\Module
     */
    public function getModule(): \Nwidart\Modules\Laravel\Module
    {
        if ($this->module == null) {
            $this->module = Module::find(Str::camel($this->argument('module')));
        }
        return $this->module;
    }

    public function getGeneratorFolder($key) {
        return $this->getModule()->getPath()
            . '/'
            . $this->laravel['config']['modules']['paths']['generator'][$key]['path']
        ;
    }

    public function getGeneratorPath($key, $name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);
        return $this->getGeneratorFolder($key)
            . '/'
            . str_replace('\\', '/', $name)
            . '.php'
        ;
    }

    public function getGeneratorNamespace($key)
    {
        $namespace = $this->rootNamespace() . $this->laravel['config']['modules']['paths']['generator'][$key]['path'];
        $namespace = str_replace('/', '\\', $namespace);

        return $namespace;
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ...parent::getArguments(),
            ['module', InputArgument::REQUIRED, 'The name of module will be used.'],
        ];
    }

    /**
     * Run the given the console command.
     *
     * @param  \Symfony\Component\Console\Command\Command|string  $command
     * @param  array  $arguments
     * @param  \Symfony\Component\Console\Output\OutputInterface  $output
     * @return int
     */
    protected function runCommand($command, array $arguments, OutputInterface $output)
    {
        $command = 'cms:'.$command.' '.$this->argument('module');
        return parent::runCommand($command, $arguments, $output);
    }
}
