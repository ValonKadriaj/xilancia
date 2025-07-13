<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $exception)
{
    if ($exception instanceof AuthenticationException) {
            return response()->json([
                'message' => 'Custom unauthenticated message via render().',
            ], 401);

    }

    return parent::render($request, $exception);
}
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Custom unauthenticated message.',
            ], 401);
        }

    }
}
