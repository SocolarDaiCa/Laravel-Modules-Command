<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands;

use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Stmt\Return_;
use SocolaDaiCa\LaravelModulesCommand\Console\Traits\GeneratorCommand;
use SocolaDaiCa\LaravelModulesCommand\PhpParse\Finder;
use SocolaDaiCa\LaravelModulesCommand\PhpParse\PhpParse;

class RequestMakeCommand extends \Illuminate\Foundation\Console\RequestMakeCommand
{
    use GeneratorCommand;

    protected function buildClass($name)
    {
        $class = parent::buildClass($name);

        $replaces = [
            'use use Illuminate\Foundation\Http\FormRequest;' => 'use SocolaDaiCa\LaravelBadassium\Illuminate\Foundation\Http\FormRequest;',
        ];

        $class = str_replace(
            array_keys($replaces),
            array_values($replaces),
            $class,
        );

        /** @var \SocolaDaiCa\LaravelModulesCommand\Overwrite\Module $module */
        $module = $this->getModule();
        $phpParse = app(PhpParse::class);

        $phpParse
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

//        /** @var Finder $finder */
//        $finder = app(Finder::class);
//        $class = $finder->findFirstClass($phpParse->getNewStmts());
//
//        $methodAuthorize = $finder->findFirstMethod($class, 'authorize');
//        /** @var Return_ $return */
//        $return = $methodAuthorize->stmts[0];
//        /** @var ConstFetch $origNode */
//        $origNode = $return->expr->getAttribute('origNode');
//        $origNode->name->name = 'xxx';
//        dd($phpParse->__toString());

        return $phpParse->__toString();
    }
}
