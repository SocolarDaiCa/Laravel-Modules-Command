<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands;

use SocolaDaiCa\LaravelModulesCommand\Console\GeneratorCommand;
use SocolaDaiCa\LaravelModulesCommand\PhpParse\PhpParse;

class RequestMakeCommand extends \Illuminate\Foundation\Console\RequestMakeCommand
{
    use GeneratorCommand;

    protected function buildClass($name)
    {
        $class = parent::buildClass($name);

        /** @var \SocolaDaiCa\LaravelModulesCommand\Overwrite\Module $module */
        $module = $this->getModule();

        $phpParse = app(PhpParse::class)
            ->parseAst($class)
            ->addMethod("
                /**
                 * Get custom attributes for validator errors.
                 *
                 * @return array
                 */
                public function attributes()
                {
                    return __('{$module->getLowerName()}::entity.');
                }
            ")
        ;

        $class = $phpParse->__toString();

        return $class;
    }
}
