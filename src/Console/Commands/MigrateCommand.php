<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\Migrations\Migrator;
use SocolaDaiCa\LaravelBadassium\Contracts\Console\Command;
use SocolaDaiCa\LaravelModulesCommand\Console\BaseCommand;
use Symfony\Component\Filesystem\Path;

class MigrateCommand extends \Illuminate\Database\Console\Migrations\MigrateCommand
{
    use BaseCommand;

    public function __construct(
        Dispatcher $dispatcher,
    )
    {
        $this->signature = str_replace('migrate', 'cms:migrate {module}', $this->signature);
        $migrator = app('migrator');

        parent::__construct($migrator, $dispatcher);
    }
}
