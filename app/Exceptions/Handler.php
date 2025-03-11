<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    //

    public function render($request, Throwable $exception)
    {
    if ($exception instanceof ModelNotFoundException) {
    return response()->json(['error' => 'Resource not found'], 404);
    }
        if ($exception instanceof MethodNotAllowedHttpException) {
        return response()->json([
        'success' => false,
        'message' => 'HTTP Method Not Allowed. Please check the request method.',
        ], 405);
        }
    return parent::render($request, $exception);
    }
}
