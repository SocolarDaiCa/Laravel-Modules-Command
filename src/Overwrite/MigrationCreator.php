<?php

namespace SocolaDaiCa\LaravelModulesCommand\Overwrite;

use SocolaDaiCa\LaravelModulesCommand\Facades\OpenPhpstorm;
use SocolaDaiCa\LaravelModulesCommand\StubModify;

class MigrationCreator extends \Illuminate\Database\Migrations\MigrationCreator
{
    protected function populateStub($stub, $table)
    {
        $code = parent::populateStub($stub, $table);

        return app(StubModify::class)->migration($stub, $table);
    }

    protected function getPath($name, $path)
    {
        return OpenPhpstorm::add(parent::getPath($name, $path));
    }
}
