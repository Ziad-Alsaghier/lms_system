<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class Handler extends ExceptionHandler
{
    //

    public function render($request, Throwable $exception)
    {
    if ($exception instanceof ModelNotFoundException) {
    return response()->json(['error' => 'Resource not found'], 404);
    }

    return parent::render($request, $exception);
    }
}
