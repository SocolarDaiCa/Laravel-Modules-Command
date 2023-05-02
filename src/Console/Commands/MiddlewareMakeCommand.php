<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands;

use SocolaDaiCa\LaravelModulesCommand\Console\GeneratorCommand;
use SocolaDaiCa\LaravelModulesCommand\PhpParse\PhpParse;
use SocolaDaiCa\LaravelModulesCommand\PhpParse\PhpParseFactory;

class MiddlewareMakeCommand extends \Illuminate\Routing\Console\MiddlewareMakeCommand
{
    use GeneratorCommand;

    protected function buildClass($name)
    {
        $class = parent::buildClass($name);

        return app(PhpParse::class)
            ->parseAst($class)
            ->addMethod('
                public static function using()
                {
                    return static::class . \':\' . implode(\',\', func_get_args());
                }
            ')
            ->__toString()
        ;
    }
}
