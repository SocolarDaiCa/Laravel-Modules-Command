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
        $options = array_values(
            array_filter($options, fn($option) => $option[0] != 'requests')
        );

        return $options;
    }

    protected function buildFormRequestReplacementsByController($controllerName)
    {
        if (Str::endsWith($controllerName, 'Controller')) {
            $controllerName = Str::beforeLast($controllerName, 'Controller');
        }

        $controllerName = Str::afterLast($controllerName, '\\Controllers\\');

        $viewFolder = $controllerName;
        $viewFolder = Str::replace('\\', '/', $viewFolder);
        $viewFolder = explode('/', $viewFolder);
        $viewFolder = collect($viewFolder)
            ->map(fn($e) => Str::lcfirst($e))
            ->map(fn($e) => Str::snake($e, '-'))
            ->join('.')
        ;
        $packageNamePrefix = Str::snake($this->module->getName(), '-');

        $requestNamespace = $this->getDefaultNamespaceByType('request');

        $indexRequestClass = "{$controllerName}\IndexRequest";
        $storeRequestClass = "{$controllerName}\StoreRequest";
        $updateRequestClass = "{$controllerName}\UpdateeRequest";
        $namespacedRequests = ""
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
            "     * @return \Illuminate\Http\Response\n" => '',
            <<<METHOD_INDEX_FROM
    public function index()
    {
        //
METHOD_INDEX_FROM => <<<METHOD_INDEX_TO
    public function index(IndexRequest \$request)
    {
        return view('{$packageNamePrefix}::pages.{$viewFolder}.index', compact([

        ]));
METHOD_INDEX_TO,
            <<<METHOD_STORE_FROM
    public function store(Request \$request)
    {
        //
METHOD_STORE_FROM => <<<METHOD_STORE_TO
    public function store(StoreRequest \$request
METHOD_STORE_TO,

            <<<METHOD_UPDATE_FROM
    public function update(Request \$request
METHOD_UPDATE_FROM => <<<METHOD_UPDATE_TO
    public function update(StoreRequest \$request
METHOD_UPDATE_TO
        ];

        return $replace;
    }

    protected function buildClass($name)
    {
        $replace = $this->buildFormRequestReplacementsByController($name);

        return str_replace(
            array_keys($replace), array_values($replace), parent::buildClass($name)
        );
    }
}
