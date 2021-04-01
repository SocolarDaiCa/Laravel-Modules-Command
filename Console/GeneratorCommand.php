<?php

namespace SocolaDaica\LaravelModulesCommand\Console;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Nwidart\Modules\Facades\Module;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

trait GeneratorCommand
{
    /**
     * Create a new controller creator command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        $this->name = 'cms:' . $this->name;
        parent::__construct($files);
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
            $this->module = Module::find($this->argument('module'));
        }
        return $this->module;
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

    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);
        return $this->module->getPath().'/'.str_replace('\\', '/', $name).'.php';
    }

    /**
     * Get class name.
     *
     * @return string
     */
    public function getClass()
    {
        return class_basename($this->argument('module'));
    }

    /**
     * Get the root namespace for the class.
     *
     * @return string
     */
    protected function rootNamespace()
    {
        $module = $this->laravel['modules'];
        $extra = str_replace($this->getClass(), '', $this->argument('module'));

        $extra = str_replace('/', '\\', $extra);

        $namespace = $this->laravel['modules']->config('namespace');

        $namespace .= '\\' . $this->getModule()->getStudlyName();

        $namespace .= '\\' . $extra;

        $namespace = str_replace('/', '\\', $namespace);

        return trim($namespace, '\\') . '\\';
    }

    /**
     * Get the first view directory path from the application configuration.
     *
     * @param  string  $path
     * @return string
     */
    protected function viewPath($path = '')
    {
        $views = $this->getModule()->getPath() . '/' . $this->laravel['config']['modules']['paths']['generator']['views']['path'];

        return $views.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    public function getGeneratorPath($key, $name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);
        return $this->getModule()->getPath()
            . '/'
            . $this->laravel['config']['modules']['paths']['generator'][$key]['path']
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

    protected function getDefaultNamespace($rootNamespace)
    {
        $type = $this->type;
        if ($type == 'component') {
            $type = 'component-class';
        }
        if (Config::has('modules.paths.generator.'.Str::lower($type).'.path')) {
            return $rootNamespace .'\\'.
                str_replace('/', '\\',
                    Config::get('modules.paths.generator.'.Str::lower($type).'.path'
                ))
            ;
        }

        return parent::getDefaultNamespace($rootNamespace);
    }
}
