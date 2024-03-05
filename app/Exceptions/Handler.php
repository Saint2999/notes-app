<?php

namespace App\Exceptions;

use App\Http\Responses\ApiErrorResponse;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException as ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException as NotFoundHttpException;
use Illuminate\Http\Response;
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
        $this->renderable(function (Throwable $e) {
            \Log::error($e->getMessage());

            if(
                $e instanceof NotFoundHttpException || 
                $e instanceof ModelNotFoundException) 
            {
                return new ApiErrorResponse(
                    [
                        'status' => Response::HTTP_NOT_FOUND,
                        'title' => 'Note does not exist'
                    ],  
                    Response::HTTP_NOT_FOUND
                );
            }

            if($e instanceof ValidationException) {
                return new ApiErrorResponse(
                    [
                        'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                        'title' => $e->getMessage()
                    ],  
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }

            return new ApiErrorResponse(
                [
                    'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                    'title' => $e->getMessage()
                ]
            );
        });
    }
}
