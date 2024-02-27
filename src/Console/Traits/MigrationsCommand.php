<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Traits;

use SocolaDaiCa\LaravelModulesCommand\Console\BaseCommand;

trait MigrationsCommand
{
    use BaseCommand;

    public function __construct()
    {
        $migrator = app('migrator');
        $this->name = 'cms:'.$this->name;
        parent::__construct($migrator);
    }
}
