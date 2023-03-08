<?php

namespace App\Exceptions;

use Throwable;
use Carbon\Carbon;
use Psr\Log\LogLevel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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

    public function render($request, Throwable $exception)
    {
        $code = $exception->getCode(); 
        $message = $exception->getMessage();
        $error = null;
        if ($exception instanceof ValidationException) {
            $code = 400;
            $message = "There was an error with the submission.";
            $error = [
                "error_validation" => $exception->validator->getMessageBag()->getMessages()
            ];
        }
        
        $content = [
            "success" => false,
            "message" => $message,
            "error" => $error
        ];
        $code = 422;
        // dd($content);
        return response()->json(
            $content,
            $code,
            [],
            JSON_UNESCAPED_SLASHES
        );
    }
}
