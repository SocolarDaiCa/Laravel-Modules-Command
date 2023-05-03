<?php

namespace SocolaDaiCa\LaravelModulesCommand;

use SocolaDaiCa\Phpstorm\Phpstiom;

class OpenPhpstorm
{
    protected array $files = [];

    public function add($file)
    {
        $this->files[] = $file;

        return $file;
    }

    public function openAll()
    {
        foreach ($this->files as $file) {
            if (file_exists($file) === false) {
                continue;
            }

            app(Phpstiom::class)->open(file: $file);
        }
    }

    public function __destruct()
    {
        $this->openAll();
    }
}
