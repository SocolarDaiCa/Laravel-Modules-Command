<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands;

use SocolaDaiCa\LaravelModulesCommand\Console\BaseCommand;

class MigrateMakeCommand extends \Illuminate\Database\Console\Migrations\MigrateMakeCommand
{
    use BaseCommand;

    protected function getMigrationPath()
    {
        return $this->getGeneratorFolder('migration');
    }
}
