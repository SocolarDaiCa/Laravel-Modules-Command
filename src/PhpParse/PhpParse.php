<?php

namespace SocolaDaiCa\LaravelModulesCommand\PhpParse;

use Illuminate\Support\Arr;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\NodeVisitorAbstract;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter\Standard;
use PhpParser\Node;


class PhpParse
{
    protected Namespace_ $ast;
    protected \PhpParser\Lexer\Emulative $lexer;
    protected \PhpParser\Parser\Php7 $parser;
    /**
     * @var \PhpParser\Node[]
     */
    protected array $newStmts;
    protected array $oldTokens;
    protected Standard $printer;
    /**
     * @var \PhpParser\Node\Stmt[]|null
     */
    protected ?array $oldStmts;
    protected \PhpParser\NodeTraverser $traverser;

    protected PhpParseFactory $phpParseFactory;

    public function __construct()
    {
        $this->lexer = new \PhpParser\Lexer\Emulative([
            'usedAttributes' => [
                'comments',
                'startLine', 'endLine',
                'startTokenPos', 'endTokenPos',
            ],
        ]);
        $this->parser = new \PhpParser\Parser\Php7($this->lexer);

        $this->traverser = new \PhpParser\NodeTraverser();
        $this->traverser->addVisitor(new \PhpParser\NodeVisitor\CloningVisitor());

        $this->printer = new \PhpParser\PrettyPrinter\Standard();
    }

    public function parseAst($code)
    {
        $this->oldStmts = $this->parser->parse($code);

        // $this->traverser->addVisitor(new class extends NodeVisitorAbstract {
        //     public function leaveNode(Node $node) {
        //         if ($node instanceof Class_) {
        //             $node->setAttributes([]);
        //             // $factory = new \PhpParser\BuilderFactory();
        //             /** @var \PhpParser\Node\Stmt\Class_ $node */
        //             /** @var ClassMethod $method */
        //             // $method = $factory
        //             //     ->method('using')
        //             //     ->makeStatic()
        //             //     ->addStmt(new Node\Stmt\Return_(
        //             //         new Node\Expr()
        //             //     ))
        //             //     ->getNode()
        //             // ;
        //             //     public static function using()
        //             //     {
        //             //         return static::class . \':\' . implode(\',\', func_get_args());
        //             //     }
        //             // $node->stmts[] = $method;
        //             return $node;
        //             // return true;
        //         }
        //         // if ($node instanceof Node\Scalar\LNumber) {
        //         //     return new Node\Scalar\String_((string) $node->value);
        //         // }
        //     }
        // });

        $this->newStmts = $this->traverser->traverse($this->oldStmts);

        $this->phpParseFactory = app(PhpParseFactory::class);
        // $this->ast = $this->parse($code);

        return $this;
    }

    public function parse($code)
    {
        $parser = (new ParserFactory())->create(ParserFactory::PREFER_PHP7);
        return $parser->parse($code)[0];
    }

    /**
     * @return mixed
     */
    public function getAst()
    {
        return $this->newStmts[0];
    }

    public function class(): Class_
    {
        return Arr::last($this->getAst()->stmts);
    }

    public function method($methodName): ClassMethod
    {
        return Arr::first(
            $this->class()->stmts,
            fn (ClassMethod $classMethod) => $classMethod->name->name == $methodName
        );
    }

    public function addMethod($code)
    {
        /** @var ClassMethod $method */
        $method = $this->phpParseFactory->makeMethod($code);
        $this->class()->stmts[] = new Node\Stmt\Nop();
        $this->class()->stmts[] = $method;

        return $this;
    }

    public function addAttribute()
    {

    }

    // public function extends($class)
    // {
    //
    // }

    public function __toString(): string
    {
        $this->oldTokens = $this->lexer->getTokens();

        return $this->printer->printFormatPreserving(
            $this->newStmts,
            $this->oldStmts,
            $this->oldTokens
        );
        // $prettyPrinter = new Standard();
        //
        // return $prettyPrinter->printFormatPreserving([$this->ast]);
        // return $prettyPrinter->prettyPrintExpr($this->ast);
    }
}