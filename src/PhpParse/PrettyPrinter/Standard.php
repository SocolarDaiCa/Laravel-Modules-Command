<?php

namespace SocolaDaiCa\LaravelModulesCommand\PhpParse\PrettyPrinter;

use SocolaDaiCa\LaravelModulesCommand\PhpParse\Stmt\Raw_;

class Standard extends \PhpParser\PrettyPrinter\Standard
{
    public function pStmt_Raw(Raw_ $node)
    {
        return implode($this->nl, $node->contents);
    }
}
