<?php

namespace SocolaDaiCa\LaravelModulesCommand\Overwrite;

class Stub extends \Nwidart\Modules\Support\Stub
{
    public function getContents()
    {
        $contents = parent::getContents();

        foreach ($this->replaces as $search => $replace) {
            $contents = str_replace('__' . strtoupper($search) . '__', $replace, $contents);
        }

        return $contents;
    }

    /**
     * Get stub path.
     *
     * @return string
     */
    public function getPath()
    {
        $path = static::getBasePath() . $this->path;

        // $pathRawFile = preg_replace('/\.stub$/', '', $path);
        //
        // dd($pathRawFile, $path);

        // if (file_exists($pathRawFile)) {
        //     return $pathRawFile;
        // }

        return file_exists($path) ? $path : preg_replace('/\.stub$/', '', $path);
        // return file_exists($path) ? $path : __DIR__ . '/../Commands/stubs' . $this->path;
    }
}
