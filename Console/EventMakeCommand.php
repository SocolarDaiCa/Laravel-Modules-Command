<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class EventMakeCommand extends \Illuminate\Foundation\Console\EventMakeCommand
{
    use GeneratorCommand;
}
