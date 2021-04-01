<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands;

use Illuminate\Console\Command;
use SocolaDaica\LaravelModulesCommand\Console\GeneratorCommand;

class ControllerMakeCommand extends \Illuminate\Routing\Console\ControllerMakeCommand
{
    use GeneratorCommand;
}
