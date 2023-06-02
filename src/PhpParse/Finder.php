<?php

namespace SocolaDaiCa\LaravelModulesCommand\PhpParse;

use PhpParser\Node;
use PhpParser\NodeFinder;

class Finder
{
    protected NodeFinder $nodeFinder;

    public function __construct()
    {
        $this->nodeFinder = new NodeFinder();
    }

    public function find(array $stmts, $type, $name = null)
    {
        return $this->nodeFinder->find($stmts, function (Node $node) use ($name, $type) {
            return $node instanceof $type
                && ($name == null || $node->name == $name);
        });
    }

    public function findFirst(array $stmts, $type, $name = null)
    {
        return $this->nodeFinder->findFirst($stmts, function (Node $node) use ($name, $type) {
            return $node instanceof $type
                && ($name == null || $node->name == $name);
        });
    }

    /**
     * @param mixed|null $name
     *
     * @return Node\Stmt\Class_[]
     */
    public function findClass(array $stmts, $name = null): array
    {
        return $this->find($stmts, Node\Stmt\Class_::class, $name);
    }

    public function findFirstClass(array $stmts, $name = null): ?Node\Stmt\Class_
    {
        return $this->findFirst($stmts, Node\Stmt\Class_::class, $name);
    }

    public function findFirstMethod(Node\Stmt\Class_ $class, $name = null): ?Node\Stmt\ClassMethod
    {
        return $this->findFirst($class->stmts, Node\Stmt\ClassMethod::class, $name);
    }
}
