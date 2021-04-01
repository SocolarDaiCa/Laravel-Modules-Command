<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands;

use Illuminate\Console\Command;
use SocolaDaica\LaravelModulesCommand\Console\GeneratorCommand;

class CastMakeCommand extends \Illuminate\Foundation\Console\CastMakeCommand
{
    use GeneratorCommand;

    protected function getDefaultNamespace($rootNamespace)
    {
        return $this->getGeneratorNamespace('cast');
    }
}
