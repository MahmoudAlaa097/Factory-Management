<?php

use App\Http\Responses\ApiResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: [
            __DIR__.'/../routes/api/base.php',
            __DIR__.'/../routes/api/v1.php',
        ],
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {

        // Validation errors
        $exceptions->render(function (ValidationException $e) {
            return ApiResponse::validationError(
                'Validation failed',
                $e->errors()
            );
        });

        // Unauthenticated — no token or invalid token
        $exceptions->render(function (AuthenticationException $e) {
            return ApiResponse::unauthorized();
        });

        // Unauthorized — valid token but forbidden action
        $exceptions->render(function (AuthorizationException $e) {
            return ApiResponse::forbidden();
        });

        // Model not found — findOrFail failed
        $exceptions->render(function (ModelNotFoundException $e) {
            $model = class_basename($e->getModel());
            return ApiResponse::notFound("{$model} not found");
        });

        // Route not found
        $exceptions->render(function (NotFoundHttpException $e) {
            return ApiResponse::notFound('Route not found');
        });

        $exceptions->render(function (HttpException $e) {
            if ($e->getStatusCode() === 403) {
                return ApiResponse::forbidden();
            }
            if ($e->getStatusCode() === 401) {
                return ApiResponse::unauthorized();
            }
            return ApiResponse::error($e->getMessage(), $e->getStatusCode());
        });

        // Catch all — keep for development, change to serverError in production
        $exceptions->render(function (Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);
        });

    })->create();
