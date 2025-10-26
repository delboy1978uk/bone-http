<?php

declare(strict_types=1);

namespace Bone\Http\Response\Json\Error;

use Bone\Http\Response\JsonResponse;

class ErrorResponse extends JsonResponse
{
    public function __construct(string|array $message, int $status = 400)
    {
        $data = [
            'status_code' => $status,
            'reason_phrase' => $message,
        ];

        parent::__construct($data, $status);
    }

}
