<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Nwidart\Modules\Facades\Module;
use SocolaDaiCa\LaravelModulesCommand\Console\BaseCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\CommonCommand;

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
