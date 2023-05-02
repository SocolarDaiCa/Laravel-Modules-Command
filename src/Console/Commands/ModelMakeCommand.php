<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands;

use Illuminate\Support\Str;
use SocolaDaiCa\LaravelModulesCommand\Console\GeneratorCommand;
use SocolaDaiCa\LaravelModulesCommand\PhpParse\PhpParse;

class ModelMakeCommand extends \Illuminate\Foundation\Console\ModelMakeCommand
{
    use GeneratorCommand;

    protected function buildClass($name)
    {
        $class = parent::buildClass($name);

        $table = Str::snake(Str::pluralStudly($this->argument('name')));

        if ($this->option('pivot')) {
            $table = Str::singular($table);
        }

        return app(PhpParse::class)
            ->parseAst($class)
            ->addMethod("
                protected \$table = '{$table}';
            ")
            ->__toString()
        ;
    }
}
