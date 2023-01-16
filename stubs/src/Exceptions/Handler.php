<?php

namespace __MODULE_NAMESPACE__\__STUDLY_NAME__\Exceptions;

use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function __construct(Container $container)
    {
        parent::__construct($container);

        $handler = app(\Illuminate\Contracts\Debug\ExceptionHandler::class);

        if ($handler instanceof \App\Exceptions\Handler) {
            $handler
                ->renderable(function (Throwable $e, $request) {
                    return $this->render($request, $e);
                })
                ->reportable(function (Throwable $e) {
                    $this->report($e);
                })
            ;
        }
    }
}
