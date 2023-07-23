<?php

namespace SocolaDaiCa\LaravelModulesCommand\Http;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

class Kernel extends ServiceProvider
{
    /**
     * The application's global HTTP middleware stack.
     *
     * This middleware is run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
    ];

    /**
     * The application's route middleware groups extend.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $extendMiddlewareGroups = [
    ];

    /**
     * The application's route middleware.
     *
     * This middleware may be assigned to group or used individually.
     *
     * @var array<string, class-string|string>
     */
    protected $routeMiddleware = [
    ];

    public function register()
    {
        //
    }

    public function boot()
    {
        $kernel = app(\Illuminate\Contracts\Http\Kernel::class);
        $router = app(Router::class);

        foreach ($this->middleware as $middleware) {
            $kernel->pushMiddleware($middleware);
        }

        foreach ($this->middlewareGroups as $groupName => $middlewares) {
            if ($router->hasMiddlewareGroup($groupName)) {
                continue;
            }

            $router->middlewareGroup($groupName, $middlewares);
        }

        foreach ($this->extendMiddlewareGroups as $groupName => $middlewares) {
            foreach ($middlewares as $middleware) {
                $router->pushMiddlewareToGroup($groupName, $middleware);
            }
        }

        foreach ($this->routeMiddleware as $alias => $middleware) {
            if (array_key_exists($alias, $router->getMiddleware())) {
                continue;
            }

            $router->aliasMiddleware($alias, $middleware);
        }
    }
}
