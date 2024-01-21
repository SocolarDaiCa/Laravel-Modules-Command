<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands;

use Illuminate\Database\Migrations\Migrator;
use SocolaDaiCa\LaravelModulesCommand\Console\BaseCommand;
use SocolaDaiCa\LaravelModulesCommand\Overwrite\MigratorForModule;

class RollbackCommand extends \Illuminate\Database\Console\Migrations\RollbackCommand
{
    use BaseCommand;

    public function __construct()
    {
        $migrator = app(MigratorForModule::class);

        parent::__construct($migrator);

        $this->setName('cms:'.$this->getName());
    }
}
