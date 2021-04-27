<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param Exception $exception
     * @return mixed|void
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof NotFoundHttpException) {
            if ($request->is('api/*')) {
                return response()->json([
                    'error_message' => $exception->getMessage(),
                    'status' => Response::HTTP_NOT_FOUND
                ]);
            }
        } elseif ($exception instanceof ValidationException) {
            if ($request->is('api/*')) {
                $validator = $exception->validator;
                $messages = $validator->getMessageBag()->getMessages();
                $key = key($messages);

                return response()->json([
                    'error_message' => $messages[$key],
                    'status' => 422
                ]);
            }
        }

        return parent::render($request, $exception);
    }
}
