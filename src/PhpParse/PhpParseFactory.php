<?php

namespace SocolaDaiCa\LaravelModulesCommand\PhpParse;

use PhpParser\Node;
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
            namespace A\\B;

            class A
            {
                {$code}
            }
        ";

        // dd($code);

        $traverser = new \PhpParser\NodeTraverser();
        $traverser->addVisitor(new class() extends NodeVisitorAbstract {
            public function leaveNode(Node $node)
            {
                $attributes = $node->getAttributes();
                unset(
                    $attributes['startLine'],
                    $attributes['startTokenPos'],
                    $attributes['endLine'],
                    $attributes['endTokenPos'],
                    $attributes['origNode'],
                );
                // $attributes['startLine'] = -1;
                // $attributes['endLine'] = 6;

                $node->setAttributes($attributes);
            }
        });

        $class = $this->phpParse->parseAst($code)->getAst()->stmts[0];

        return $traverser->traverse($class->stmts)[0];
    }
}
