<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands;

use SocolaDaiCa\LaravelModulesCommand\Console\GeneratorCommand;
use Symfony\Component\Console\Output\OutputInterface;

class ModelMakeCommand extends \Illuminate\Foundation\Console\ModelMakeCommand
{
    use GeneratorCommand;
}
