<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands;

use SocolaDaiCa\LaravelModulesCommand\Console\GeneratorCommand;
use SocolaDaiCa\LaravelModulesCommand\StubModify;

class ResourceMakeCommand extends \Illuminate\Foundation\Console\ResourceMakeCommand
{
    use GeneratorCommand;

    protected function buildClass($name)
    {
        $code = parent::buildClass($name);

        /** @var StubModify $stubModify */
        $stubModify = app(StubModify::class);

        $stubModify->resource($code);

        return $code;
    }
}
