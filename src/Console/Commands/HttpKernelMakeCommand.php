<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands;

use Nwidart\Modules\Commands\GeneratorCommand;
use Nwidart\Modules\Support\Config\GenerateConfigReader;
use Nwidart\Modules\Support\Stub;
use Nwidart\Modules\Traits\ModuleCommandTrait;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class HttpKernelMakeCommand extends GeneratorCommand
{
    use ModuleCommandTrait;

    protected $argumentName = 'module';

    /**
     * The command name.
     *
     * @var string
     */
    protected $name = 'cms:make:http-kernel';

    /**
     * The command description.
     *
     * @var string
     */
    protected $description = 'Create a new http kernel for the specified module.';

    /**
     * The command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['module', InputArgument::OPTIONAL, 'The name of module will be used.'],
        ];
    }

    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Force the operation to run when the file already exists.'],
        ];
    }

    /**
     * Get template contents.
     *
     * @return string
     */
    protected function getTemplateContents()
    {
        $module = $this->laravel['modules']->findOrFail($this->getModuleName());

        return (new Stub('/http-kernel.stub', [
            'NAMESPACE' => $this->getClassNamespace($module),
            // 'CLASS'                => $this->getFileName(),
            // 'MODULE_NAMESPACE'     => $this->laravel['modules']->config('namespace'),
            // 'MODULE'               => $this->getModuleName(),
            // 'CONTROLLER_NAMESPACE' => $this->getControllerNameSpace(),
            // 'WEB_ROUTES_PATH'      => $this->getWebRoutesPath(),
            // 'API_ROUTES_PATH'      => $this->getApiRoutesPath(),
            // 'LOWER_NAME'           => $module->getLowerName(),
        ]))->render();
    }

    /**
     * @return string
     */
    private function getFileName()
    {
        return 'Kernel';
    }

    /**
     * Get the destination file path.
     *
     * @return string
     */
    protected function getDestinationFilePath()
    {
        $path = $this->laravel['modules']->getModulePath($this->getModuleName());

        $generatorPath = GenerateConfigReader::read('http-kernel');

        return $path.$generatorPath->getPath().'/'.$this->getFileName().'.php';
    }

    // /**
    //  * @return mixed
    //  */
    // protected function getWebRoutesPath()
    // {
    //     return '/' . $this->laravel['modules']->config('stubs.files.routes/web', 'Routes/web.php');
    // }
    //
    // /**
    //  * @return mixed
    //  */
    // protected function getApiRoutesPath()
    // {
    //     return '/' . $this->laravel['modules']->config('stubs.files.routes/api', 'Routes/api.php');
    // }

    public function getDefaultNamespace(): string
    {
        $module = $this->laravel['modules'];

        return $module->config('paths.generator.http-kernel.namespace') ?: $module->config('paths.generator.http-kernel.path', 'Http');
    }
    //
    // /**
    //  * @return string
    //  */
    // private function getControllerNameSpace(): string
    // {
    //     $module = $this->laravel['modules'];
    //
    //     return str_replace('/', '\\', $module->config('paths.generator.controller.namespace') ?: $module->config('paths.generator.controller.path', 'Controller'));
    // }
}
