<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands;

use Illuminate\Support\Str;
use SocolaDaiCa\LaravelModulesCommand\Console\GeneratorCommand;

class ControllerMakeCommand extends \Illuminate\Routing\Console\ControllerMakeCommand
{
    use GeneratorCommand;

    protected function getOptions()
    {
        $options = parent::getOptions();

        return array_values(
            array_filter($options, fn ($option) => $option[0] != 'requests')
        );
    }

    protected function buildFormRequestReplacementsByController($controllerName)
    {
        if (!$this->option('resource') && !$this->option('api')) {
            return [];
        }

        if (Str::endsWith($controllerName, 'Controller')) {
            $controllerName = Str::beforeLast($controllerName, 'Controller');
        }

        $controllerName = Str::afterLast($controllerName, '\\Controllers\\');

        $viewFolder = $controllerName;
        $viewFolder = Str::replace('\\', '/', $viewFolder);
        $viewFolder = explode('/', $viewFolder);
        $viewFolder = collect($viewFolder)
            ->map(fn ($e) => Str::lcfirst($e))
            ->map(fn ($e) => Str::snake($e, '-'))
            ->join('.')
        ;
        $packageNamePrefix = Str::snake($this->module->getName(), '-');

        $requestNamespace = $this->getDefaultNamespaceByType('request');

        $indexRequestClass = "{$controllerName}\\IndexRequest";
        $storeRequestClass = "{$controllerName}\\StoreRequest";
        $updateRequestClass = "{$controllerName}\\UpdateRequest";
        $namespacedRequests = ''
            ."use {$requestNamespace}\\{$indexRequestClass};".PHP_EOL
            ."use {$requestNamespace}\\{$storeRequestClass};".PHP_EOL
            ."use {$requestNamespace}\\{$updateRequestClass};"
        ;

        $this->call('make:request', [
            'name' => $indexRequestClass,
        ]);

        $this->call('make:request', [
            'name' => $storeRequestClass,
        ]);

        $this->call('make:request', [
            'name' => $updateRequestClass,
        ]);

        $replace = [
            'use Illuminate\\Http\\Request;' => $namespacedRequests,
            "     * @return \\Illuminate\\Http\\Response\n" => '',
        ];

        if ($this->option('api')) {
            $replace[<<<METHOD_INDEX_FROM
    public function index()
METHOD_INDEX_FROM] = <<<METHOD_INDEX_TO
    public function index(IndexRequest \$request)
METHOD_INDEX_TO;
        }

        $replace[<<<METHOD_STORE_FROM
    public function store(Request \$request)
METHOD_STORE_FROM] = <<<METHOD_STORE_TO
    public function store(StoreRequest \$request)
METHOD_STORE_TO;

        $replace[<<<METHOD_UPDATE_FROM
    public function update(Request \$request
METHOD_UPDATE_FROM] = <<<METHOD_UPDATE_TO
    public function update(StoreRequest \$request
METHOD_UPDATE_TO;

        if ($this->option('resource')) {
            $replace[<<<METHOD_INDEX_FROM
    public function index()
    {
        //
METHOD_INDEX_FROM] = <<<METHOD_INDEX_TO
    public function index(IndexRequest \$request)
    {
        return view('{$packageNamePrefix}::pages.{$viewFolder}.index', compact([

        ]));
METHOD_INDEX_TO;

            $replace[<<<METHOD_CREATE_FROM
    public function create(\$id)
    {
        //
METHOD_CREATE_FROM] = <<<METHOD_STORE_TO
    public function create()
    {
        return view('{$packageNamePrefix}::pages.{$viewFolder}.form', compact([

        ]));
METHOD_STORE_TO;

            $replace[<<<METHOD_CREATE_FROM
    public function edit(\$id)
    {
        //
METHOD_CREATE_FROM] = <<<METHOD_STORE_TO
    public function edit(\$id)
    {
        return view('{$packageNamePrefix}::pages.{$viewFolder}.form', compact([

        ]));
METHOD_STORE_TO;
        }
        /* todo: template cho option model */

        return $replace;
    }

    protected function buildClass($name)
    {
        $replace = $this->buildFormRequestReplacementsByController($name);

        return str_replace(
            array_keys($replace),
            array_values($replace),
            parent::buildClass($name)
        );
    }
}
