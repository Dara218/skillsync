<?php

use App\Http\Middleware\{
    RedirectIfAuthenticated,
    UserAccess,
};
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\{
    Exceptions,
    Middleware,
};
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'guest' => RedirectIfAuthenticated::class,
            'user' => UserAccess::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (HttpException $e) {
            $statusCode = $e->getStatusCode();
            $errorDetails = match ($statusCode) {
                400 => [
                    'title' => __('lang.errors.bad_request.title'),
                    'message' => __('lang.errors.bad_request.message'),
                ],
                401 => [
                    'title' => __('lang.errors.unauthorized.title'),
                    'message' => __('lang.errors.unauthorized.message'),
                ],
                403 => [
                    'title' => __('lang.errors.forbidden.title'),
                    'message' => __('lang.errors.forbidden.message'),
                ],
                404 => [
                    'title' => __('lang.errors.not_found.title'),
                    'message' => __('lang.errors.not_found.message'),
                ],
                419 => [
                    'title' => __('lang.errors.expired.title'),
                    'message' => __('lang.errors.expired.message'),
                ],
                429 => [
                    'title' => __('lang.errors.too_many_request.title'),
                    'message' => __('lang.errors.too_many_request.message'),
                ],
                500 => [
                    'title' => __('lang.errors.internal_server_error.title'),
                    'message' => __('lang.errors.internal_server_error.message'),
                ],
                502 => [
                    'title' => __('lang.errors.bad_gateway.title'),
                    'message' => __('lang.errors.bad_gateway.message'),
                ],
                503 => [
                    'title' => __('lang.errors.service_unavailable.title'),
                    'message' => __('lang.errors.service_unavailable.message'),
                ],
                504 => [
                    'title' => __('lang.errors.gateway_timeout.title'),
                    'message' => __('lang.errors.gateway_timeout.message'),
                ],
                default => [
                    'title' => __('lang.errors.internal_server_error.title'),
                    'message' => __('lang.errors.internal_server_error.message'),
                ],
            };

            return response()->view('errors.default', [
                'statusCode' => $statusCode,
                'title' => $errorDetails['title'],
                'message' => $errorDetails['message'],
            ]);
        });
    })->create();