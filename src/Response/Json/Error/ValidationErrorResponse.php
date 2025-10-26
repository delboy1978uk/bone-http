<?php

declare(strict_types=1);

namespace Bone\Http\Response\Json\Error;

use Bone\Http\Response\JsonResponse;

class ValidationErrorResponse extends JsonResponse
{
    public function __construct(string|array $message)
    {
        $data = [
            'status_code' => 422,
            'reason_phrase' => $message,
        ];

        parent::__construct($data, 422);
    }
}
