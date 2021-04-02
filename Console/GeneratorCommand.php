<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Nwidart\Modules\Facades\Module;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

trait GeneratorCommand
{
    use CommonCommand;
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

    protected function getDefaultNamespace($rootNamespace)
    {
        $type = Str::lower($this->type);
        $types = [
            'console command' => 'command',
            'component'       => 'component-class',
        ];

        $type = $types[$type] ?? $type;

        if (Config::has('modules.paths.generator.'.$type.'.path') == false) {
            return parent::getDefaultNamespace($rootNamespace);
        }

        return $rootNamespace.'\\'.str_replace('/', '\\',
            Config::get('modules.paths.generator.'.$type.'.path')
        );
    }
}
