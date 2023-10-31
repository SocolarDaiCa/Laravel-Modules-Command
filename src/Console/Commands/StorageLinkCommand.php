<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use SocolaDaiCa\LaravelModulesCommand\Console\CommonCommand;

class StorageLinkCommand extends \Illuminate\Foundation\Console\StorageLinkCommand
{
    use CommonCommand;

    protected function links()
    {
        $vendorNamespace = "{$this->getModule()->getComposerAttr('name')}";
        $author = Str::before($vendorNamespace, '/');
        $vendorRelativePath = "vendor/{$vendorNamespace}";
        File::makeDirectory(public_path("vendor/{$author}"), '0000', true, true);

        return [
            public_path($vendorRelativePath) => "{$this->getModule()->getPath()}/public/{$vendorRelativePath}",
        ];
    }
}
