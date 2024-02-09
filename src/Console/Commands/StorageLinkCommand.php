<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use SocolaDaiCa\LaravelModulesCommand\Console\CommonCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Traits\StorageCommand;

class StorageLinkCommand extends \Illuminate\Foundation\Console\StorageLinkCommand
{
    use StorageCommand;
}
