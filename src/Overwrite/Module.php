<?php

namespace SocolaDaiCa\LaravelModulesCommand\Overwrite;

use Illuminate\Support\Str;

class Module extends \Nwidart\Modules\Laravel\Module
{
    public function getLowerName(): string
    {
        return Str::kebab($this->name);
    }
}
