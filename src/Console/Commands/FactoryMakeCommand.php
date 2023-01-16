<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands;

use SocolaDaiCa\LaravelModulesCommand\Console\GeneratorCommand;

class FactoryMakeCommand extends \Illuminate\Database\Console\Factories\FactoryMakeCommand
{
    use GeneratorCommand;

    protected function getPath($name)
    {
        return $this->getGeneratorPath('factory', $name);
    }

    protected function buildClass($name)
    {
        return str_replace(
            'namespace DatabaseTest\Factories;',
            'namespace ' . $this->getGeneratorNamespace('factory') . ';',
            parent::buildClass($name)
        );
    }

    protected function qualifyModel(string $model)
    {
        return str_replace(
            $this->rootNamespace().'Models\\',
            $this->getGeneratorNamespace('model').'\\',
            parent::qualifyModel($model)
        );
    }
}
