<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands\Migrations;

use Illuminate\Console\Command;
use Illuminate\Database\Migrations\MigrationCreator;
use Illuminate\Database\Migrations\Migrator;
use Illuminate\Support\Composer;
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
