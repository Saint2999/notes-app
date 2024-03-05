<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Response;

class ApiErrorResponse implements Responsable
{
    public function __construct(
        private mixed $errors,
        private int $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR,
        private array $headers = [],
    ) {
    }

    public function toResponse($request)
    {
        return response()->json(
            [
                'errors' => $this->errors,
            ], 
            $this->statusCode,
            $this->headers
        );
    }
}