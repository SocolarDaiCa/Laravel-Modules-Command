<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands;

use Illuminate\Console\Command;
use SocolaDaica\LaravelModulesCommand\Console\GeneratorCommand;

class MiddlewareMakeCommand extends \Illuminate\Routing\Console\MiddlewareMakeCommand
{
    use GeneratorCommand;
}
