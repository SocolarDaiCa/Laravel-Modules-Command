<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands;

use Illuminate\Support\Str;
use Nwidart\Modules\Module;
use Nwidart\Modules\Support\Config\GenerateConfigReader;
use SocolaDaiCa\LaravelModulesCommand\Overwrite\Stub;

class ProviderMake1Command extends \Nwidart\Modules\Commands\ProviderMakeCommand
{
    protected $name = 'cms:make:make-provider';

    protected function getTemplateContents()
    {
        $stub = $this->option('master') ? 'scaffold/provider' : 'provider';

        /** @var Module $module */
        $module = $this->laravel['modules']->findOrFail($this->getModuleName());

        return (new Stub('/' . $stub . '.stub', [
            'NAMESPACE'         => $this->getClassNamespace($module),
            'KERNEL_NAMESPACE' => GenerateConfigReader::read('http-kernel')->getNamespace().'Kernel',
            'CLASS'             => $this->getClass(),
            'LOWER_NAME'        => $module->getLowerName(),
            'MODULE'            => $this->getModuleName(),
            'NAME'              => $this->getFileName(),
            'STUDLY_NAME'       => $module->getStudlyName(),
            'MODULE_NAMESPACE'  => $this->laravel['modules']->config('namespace'),
            'PATH_VIEWS'        => GenerateConfigReader::read('views')->getPath(),
            'PATH_LANG'         => GenerateConfigReader::read('lang')->getPath(),
            'PATH_CONFIG'       => GenerateConfigReader::read('config')->getPath(),
            'MIGRATIONS_PATH'   => GenerateConfigReader::read('migration')->getPath(),
            'FACTORIES_PATH'    => GenerateConfigReader::read('factory')->getPath(),
        ]))->render();
    }

    /**
     * @return string
     */
    private function getFileName()
    {
        return Str::studly($this->argument('name'));
    }
}
