<?php

namespace SocolaDaiCa\LaravelModulesCommand\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \SocolaDaiCa\LaravelModulesCommand\OpenPhpstorm
 * @mixin \SocolaDaiCa\LaravelModulesCommand\OpenPhpstorm
 */
class OpenPhpstorm extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \SocolaDaiCa\LaravelModulesCommand\OpenPhpstorm::class;
    }
}
