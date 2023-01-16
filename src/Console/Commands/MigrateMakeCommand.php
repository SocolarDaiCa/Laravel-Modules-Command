<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands;

use Illuminate\Database\Migrations\MigrationCreator;
use Illuminate\Support\Composer;
use SocolaDaiCa\LaravelModulesCommand\Console\BaseCommand;

class MigrateMakeCommand extends \Illuminate\Database\Console\Migrations\MigrateMakeCommand
{
    use BaseCommand;
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

    /**
     * Get migration path (either specified by '--path' option or default location).
     *
     * @return string
     */
    protected function getMigrationPath()
    {
        return $this->getGeneratorFolder('migration');
//        if (! is_null($targetPath = $this->input->getOption('path'))) {
//            return ! $this->usingRealPath()
//                ? $this->laravel->basePath().'/'.$targetPath
//                : $targetPath;
//        }
//
//        return parent::getMigrationPath();
    }
}
