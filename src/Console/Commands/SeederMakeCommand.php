<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands;

use SocolaDaiCa\LaravelModulesCommand\Console\GeneratorCommand;

class SeederMakeCommand extends \Illuminate\Database\Console\Seeds\SeederMakeCommand
{
    use GeneratorCommand;

    protected function getPath($name)
    {
        return $this->getGeneratorPath('seeder', $name);
    }

    protected function buildClass($name)
    {
        return str_replace(
            'namespace DatabaseTest\Seeders;',
            'namespace ' . $this->getGeneratorNamespace('seeder') . ';',
            parent::buildClass($name)
        );
    }
}
