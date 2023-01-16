<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands\Migrations;

use SocolaDaiCa\LaravelModulesCommand\Console\BaseCommand;

class StatusCommand extends \Illuminate\Database\Console\Migrations\StatusCommand
{
    use BaseCommand;
    public function __construct()
    {
        $migrator = app("migrator");
        $this->name = 'cms:'.$this->name;
        parent::__construct($migrator);
    }
}
