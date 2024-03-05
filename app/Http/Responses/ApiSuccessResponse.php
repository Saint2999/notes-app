<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Response;

class ApiSuccessResponse implements Responsable
{
    public function __construct(
        private mixed $data,
        private array $links,
        private int $statusCode = Response::HTTP_OK,
        private array $headers = []
    ) {}

    public function toResponse($request)
    {
        return response()->json(
            [
                'data' => $this->data,
                'links' => $this->links
            ], 
            $this->statusCode, 
            $this->headers
        );
    }
}