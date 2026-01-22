<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands;

use Illuminate\Support\Str;
use SocolaDaiCa\LaravelModulesCommand\Console\Traits\GeneratorCommand;
use SocolaDaiCa\LaravelModulesCommand\Facades\OpenPhpstorm;
use Symfony\Component\Filesystem\Path;

class ViewMakeCommand extends \Illuminate\Foundation\Console\ViewMakeCommand
{
    use GeneratorCommand;

    protected function getPath($name)
    {
        return OpenPhpstorm::add(parent::getPath($name));
    }

    protected function resolveStubPath($stub)
    {
        if (
            (
                Str::endsWith($this->argument('module'), '-admin')
                || Str::contains($this->argument('module'), '-admin-')
            )
        ) {
            $page = Str::afterLast($this->argument('name'), '.');
            $path = Path::join(module_path('admin'), "stubs/resources/views/pages/{$page}.blade.php");

            if (file_exists($path)) {
                return $path;
            }
        }

        return parent::resolveStubPath($stub);
    }

    protected function buildClass($name)
    {
        $contents = parent::buildClass($name);
        $module = $this->argument('module');
        $name = $this->argument('name');
        $namePrefix = Str::beforeLast($name, '.');

        $replacements = [
            '<<route_prefix>>' => "{$module}::{$namePrefix}",
        ];

        return str_replace(
            array_keys($replacements),
            array_values($replacements),
            $contents,
        );
    }
}
