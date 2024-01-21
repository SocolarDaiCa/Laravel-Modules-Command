<?php

namespace SocolaDaiCa\LaravelModulesCommand\Overwrite;

use Illuminate\Console\View\Components\Info;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\ConnectionResolverInterface as Resolver;
use Illuminate\Database\Events\NoPendingMigrations;
use Illuminate\Database\Migrations\MigrationRepositoryInterface;
use Illuminate\Database\Migrations\Migrator;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;

class MigratorForModule extends Migrator
{
    public function __construct(Resolver $resolver, Filesystem $files, Dispatcher $dispatcher = null)
    {
        $repository = app('migration.repository');
        parent::__construct($repository, $resolver, $files, $dispatcher);
    }

    /**
     * Rollback the last migration operation.
     *
     * @param  array|string  $paths
     * @param  array  $options
     * @return array
     */
    public function rollback($paths = [], array $options = [])
    {
        // We want to pull in the last batch of migrations that ran on the previous
        // migration operation. We'll then reverse those migrations and run each
        // of them "down" to reverse the last migration "operation" which ran.
        $_options = (array) $options;
        unset($_options['step']);
        $_options['step'] = PHP_INT_MAX;
        unset($_options['batch']);
        $migrations = $this->getMigrationsForRollback($_options, $paths);
        $migrationFiles = $this->getMigrationFiles($paths);

        $migrations = array_filter($migrations, function ($migration) use ($migrationFiles) {
            return array_key_exists($migration->migration, $migrationFiles);
        });
        $migrations = array_values($migrations);

        if ($options['step'] > 0) {
            $migrations = array_slice($migrations, 0, $options['step']);
        }

        if (count($migrations) === 0) {
            $this->fireMigrationEvent(new NoPendingMigrations('down'));

            $this->write(Info::class, 'Nothing to rollback.');

            return [];
        }

        return tap($this->rollbackMigrations($migrations, $paths, $options), function () {
            if ($this->output) {
                $this->output->writeln('');
            }
        });
    }
}
