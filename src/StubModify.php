<?php

namespace SocolaDaiCa\LaravelModulesCommand;
use Illuminate\Support\Str;
use PhpParser\Comment;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\ControllerMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\PhpParse\Finder;
use SocolaDaiCa\LaravelModulesCommand\PhpParse\PhpParse;
use PhpParser\Node;
use SocolaDaiCa\LaravelModulesCommand\PhpParse\Stmt\Raw_;

class StubModify
{
    public function migration($stub, $table)
    {
        $phpParse = app(PhpParse::class)
            ->parseAst($stub)
        ;

        $nodeFinder = new \PhpParser\NodeFinder();
        /** @var Finder $finder */
        $finder = app(Finder::class);

        $class = $finder->findFirstClass($phpParse->getNewStmts());

        $methodUp = $finder->findFirstMethod($class, 'up');

        /** @var Node\Expr\Closure $closure */
        $closure = $finder->findFirst($methodUp->stmts, Node\Expr\Closure::class);

        $closureStmts = $closure->stmts;
        $closure->stmts = [];

        if ($closureStmts) {
            $closure->stmts[] = array_shift($closureStmts);

            if (in_array($table, ['categories'])) {
                $closure->stmts[] = $phpParse->parseRawCode('$table->string(\'name\');')[0];
            }
        }

        if ($closureStmts) {
            $closure->stmts[] = $phpParse->parseRawCode('$table->softDeletes();')[0];
            $closure->stmts[] = array_shift($closureStmts);

            if (in_array($table, ['categories'])) {
                $closure->stmts[] = $phpParse->parseRawCode('/**/')[0];
                $closure->stmts[] = $phpParse->parseRawCode('$table->unique([\'name\']);')[0];
            }
        }

        return $phpParse->__toString();
    }

    public function controller($stub, bool $api = false, string $model = '')
    {
        $phpParse = app(PhpParse::class)
            ->parseAst($stub)
        ;

        /** @var Finder $finder */
        $finder = app(Finder::class);

        /* index */
        $class = $finder->findFirstClass($phpParse->getNewStmts());
        $methodIndex = $finder->findFirstMethod($class, 'index');

        $modelName = Str::afterLast($model, '\\');

        if ($methodIndex && $api && $model) {
            $methodIndex->stmts[0] = new Raw_("
                \$items = {$model}::query()
                    ->paginate()
                ;

                return {$modelName}Resource::collection(\$items);
            ");
        }

        $methodStore = $finder->findFirstMethod($class, 'store');
        if ($methodStore && $api && $model) {
            $methodStore->stmts[0] = new Raw_("
                \$item = {$modelName}::query()->create(\$request->validated();

                return {$modelName}Resource::make(\$item);
            ");
        }

        $methodShow = $finder->findFirstMethod($class, 'show');
        if ($methodShow && $api && $model) {
            $methodShow->stmts[0] = new Raw_("
                return {$modelName}Resource::make(\${$methodShow->params[0]->var->name});
            ");
        }

        $methodUpdate = $finder->findFirstMethod($class, 'update');
        if ($methodUpdate && $api && $model) {
            $methodUpdate->stmts[0] = new Raw_("
                return {$modelName}Resource::make(\${$methodUpdate->params[1]->var->name});
            ");
        }

        $methodDestroy = $finder->findFirstMethod($class, 'destroy');
        if ($methodDestroy && $api && $model) {
            $methodDestroy->stmts[0] = new Raw_("
                \${$methodDestroy->params[0]->var->name}->delete();
            ");
        }

        return $phpParse->__toString();
    }

    public function resource($stub, $model)
    {
        if ($model) {
            $model = '\\' . ltrim($model, '\\');
        }

        $phpParse = app(PhpParse::class)
            ->parseAst($stub)
        ;

        /** @var Finder $finder */
        $finder = app(Finder::class);

        $class = $finder->findFirstClass($phpParse->getNewStmts());

        $class->setAttribute('comments', [
            new Comment\Doc("/**
 * @see {$model}
 * @mixin {$model}
 */")
    ]);

        return $phpParse->__toString();
    }
}
