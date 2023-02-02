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
        // if (!file_exists(public_path('vendor'))) {
        //     mkdir(public_path('vendor'), 0000);
        // }
        //
        // chmod(public_path('vendor'), 000);
        //
        // // $vendorNamespace = "{$this->getModule()->getComposerAttr('name')}";
        //
        // return [
        //     // public_path("vendor/{$this->getModule()->getLowerName()}") => "{$this->getModule()->getPath()}/public",
        //     // public_path("vendor/{$vendorNamespace}") => "{$this->getModule()->getPath()}/public/{$vendorNamespace}",
        //     public_path("vendor/{$this->getModule()->getLowerName()}") => "{$this->getModule()->getPath()}/public/",
        // ];

        $vendorNamespace = "{$this->getModule()->getComposerAttr('name')}";
        $author = Str::before($vendorNamespace, '/');
        $vendorRelativePath = "vendor/{$vendorNamespace}";
        File::makeDirectory(public_path("vendor/{$author}"), '0000', true, true);

        return [
            public_path($vendorRelativePath) => "{$this->getModule()->getPath()}/public/{$vendorRelativePath}",
        ];
    }
}
