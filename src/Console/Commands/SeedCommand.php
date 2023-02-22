<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands;

use Illuminate\Database\ConnectionResolverInterface as Resolver;
use SocolaDaiCa\LaravelModulesCommand\Console\CommonCommand;

class SeedCommand extends \Illuminate\Database\Console\Seeds\SeedCommand
{
    use CommonCommand;

    /**
     * Create a new database seed command instance.
     */
    public function __construct(Resolver $resolver)
    {
        parent::__construct($resolver);
    }
}
