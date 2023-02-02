<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Nwidart\Modules\Support\Config\GenerateConfigReader;
use Nwidart\Modules\Traits\ModuleCommandTrait;
use SocolaDaiCa\LaravelModulesCommand\Helper;
use Symfony\Component\Console\Output\OutputInterface;

trait GeneratorCommand
{
    use ModuleCommandTrait;
    use CommonCommand;

    /**
     * Create a new controller creator command instance.
     *
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        $this->name = 'cms:'.$this->name;
        parent::__construct($files);
    }

    protected function getPath($name)
    {
        return $this->getDestinationFilePath();
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
        $module = $this->getModule();

        if ($module->get('namespace')) {
            return trim($module->get('namespace'), '\\').'\\';
        }

        $extra = str_replace($this->getClass(), '', $this->argument('module'));

        $extra = str_replace('/', '\\', $extra);

        $namespace = $this->laravel['modules']->config('namespace');

        $namespace .= '\\'.$module->getStudlyName();

        $namespace .= '\\'.$extra;

        $namespace = str_replace('/', '\\', $namespace);

        return trim($namespace, '\\').'\\';
    }

    /**
     * Get the first view directory path from the application configuration.
     *
     * @param string $path
     *
     * @return string
     */
    protected function viewPath($path = '')
    {
        $views = $this->getModule()->getPath().'/'.$this->laravel['config']['modules']['paths']['generator']['views']['path'];

        return $views.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    public function getDefaultNamespace($rootNamespace)
    {
        $type = $this->getType();
        $module = $this->laravel['modules'];

        $namespace = $module->config("paths.generator.{$type}.namespace") ?: $module->config("paths.generator.{$type}.path");

        return $rootNamespace.'\\'.str_replace('/', '\\', $namespace);
    }

    public function getType()
    {
        $type = Str::lower($this->type);
        $types = [
            'console command' => 'command',
            'component' => 'component-class',
        ];

        return $types[$type] ?? $type;
    }

    protected function getDestinationFilePath()
    {
        $path = $this->laravel['modules']->getModulePath($this->getModuleName());

        $commandPath = GenerateConfigReader::read($this->getType());

        return $path.$commandPath->getPath().'/'.$this->getFileName().'.php';
    }

    /**
     * @return string
     */
    private function getFileName()
    {
        $filename = $this->argument('name');
        $filename = Str::replace(['.', '/', '\\'], '/', $filename);

        return collect(explode('/', $filename))
            ->map(fn ($item) => trim(Str::studly($item), '/'))
            ->join('/')
        ;
    }

    public function handle()
    {
        Helper::overwrireModulesConfig();

        return parent::handle();
    }

    // public function call($command, array $arguments = [])
    // {
    //     if (Str::start($command, 'make:')) {
    //         $command = "cms:{$command}";
    //     }
    //     dump($command);
    //
    //     parent::call($command, $arguments);
    // }

    protected function runCommand($command, array $arguments, OutputInterface $output)
    {
        // dump($command);
        $command = "cms:{$command}";
        $arguments['module'] = $this->argument('module');

        return parent::runCommand($command, $arguments, $output);
    }
}
