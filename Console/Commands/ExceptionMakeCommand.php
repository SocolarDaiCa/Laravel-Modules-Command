<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands;

use Illuminate\Console\Command;
use SocolaDaica\LaravelModulesCommand\Console\GeneratorCommand;

class ExceptionMakeCommand extends \Illuminate\Foundation\Console\ExceptionMakeCommand
{
    use GeneratorCommand;
}
