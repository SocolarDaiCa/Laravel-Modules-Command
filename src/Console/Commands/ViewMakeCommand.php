<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands;

use Nwidart\Modules\Support\Config\GenerateConfigReader;
use SocolaDaiCa\LaravelModulesCommand\Console\GeneratorCommand;
use SocolaDaiCa\LaravelModulesCommand\Facades\OpenPhpstorm;
use Symfony\Component\Filesystem\Path;

class ViewMakeCommand extends \Illuminate\Foundation\Console\ViewMakeCommand
{
    use GeneratorCommand;

    protected function getPath($name)
    {
        return OpenPhpstorm::add(parent::getPath($name));
    }
}
