<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console;

use Illuminate\Console\Command;
use Illuminate\Database\Migrations\MigrationCreator;
use Illuminate\Support\Composer;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

trait BaseCommand
{
    /**
     * Create a new migration install command instance.
     *
     * @param  \Illuminate\Database\Migrations\MigrationCreator  $creator
     * @param  \Illuminate\Support\Composer  $composer
     * @return void
     */
    public function __construct(MigrationCreator $creator, Composer $composer)
    {
        $this->signature = 'cms:' . $this->signature . '{module}';
        parent::__construct($creator, $composer);
    }
}
