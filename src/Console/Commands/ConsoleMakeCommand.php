<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands;

use SocolaDaiCa\LaravelModulesCommand\Console\GeneratorCommand;
use SocolaDaiCa\LaravelModulesCommand\Facades\OpenPhpstorm;

class ConsoleMakeCommand extends \Illuminate\Foundation\Console\ConsoleMakeCommand
{
    use GeneratorCommand;

    protected function buildClass($name)
    {
        $code = parent::buildClass($name);

        $replaces = [
            'use Illuminate\Console\Command;' => 'use SocolaDaiCa\LaravelBadassium\Contracts\Console\Command;',
        ];

        return str_replace(array_keys($replaces), array_values($replaces), $code);
    }
}
