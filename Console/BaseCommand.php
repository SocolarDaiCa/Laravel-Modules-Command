<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console;

use Illuminate\Console\Command;
use Illuminate\Database\Migrations\MigrationCreator;
use Illuminate\Support\Composer;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

trait BaseCommand
{
    use CommonCommand;
}
