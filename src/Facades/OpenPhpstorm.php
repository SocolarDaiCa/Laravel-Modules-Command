<?php

namespace SocolaDaiCa\LaravelModulesCommand\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void add(void $file)
 * @method static void openAll()
 *
 * @see \SocolaDaiCa\LaravelModulesCommand\OpenPhpstorm
 *
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
