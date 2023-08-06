<?php

namespace SocolaDaiCa\LaravelModulesCommand\Http;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

class Kernel extends \SocolaDaiCa\LaravelBadassium\Contracts\Http\Kernel
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
}
