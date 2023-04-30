<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }




    public function render($request, Throwable $exception)
    {
        
        if ($exception instanceof \Illuminate\Database\QueryException) {
            $errorMessage = $exception->getMessage();
            return response()->json(['message' => $errorMessage], 500);
        }

        // Handle other types of exceptions here, or call the parent handler to handle them

        return parent::render($request, $exception);
    }
}
