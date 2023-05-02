<?php

namespace SocolaDaiCa\LaravelModulesCommand\PhpParse;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\NodeVisitorAbstract;

class PhpParseFactory
{
    protected PhpParse $phpParse;

    public function __construct()
    {
        $this->phpParse = app(PhpParse::class);
    }

    public function makeMethod($code)
    {
        $code = "<?php
            namespace A\B;

            class A
            {
                {$code}
            }
        ";

        // dd($code);

        $traverser = new \PhpParser\NodeTraverser();
        $traverser->addVisitor(new class extends NodeVisitorAbstract {
            public function leaveNode(Node $node) {
                $attributes = $node->getAttributes();
                unset($attributes['startLine']);
                unset($attributes['startTokenPos']);
                unset($attributes['endLine']);
                unset($attributes['endTokenPos']);
                unset($attributes['origNode']);
                $node->setAttributes($attributes);
            }
        });

        $class = $this->phpParse->parseAst($code)->getAst()->stmts[0];

        return $traverser->traverse($class->stmts)[0];
    }
}
