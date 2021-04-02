<?php
namespace SocolaDaiCa\LaravelModulesCommand\Console;

use Illuminate\Support\Str;
use Nwidart\Modules\Facades\Module;
use Symfony\Component\Console\Input\InputArgument;

trait CommonCommand {

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

}
