<?php

declare(strict_types=1);

namespace Bone\Http\Response\Json\Error;

use Bone\Http\Response\JsonResponse;

class ServerErrorResponse extends JsonResponse
{
    public function __construct(string|array $message)
    {
        $data = [
            'status_code' => 500,
            'reason_phrase' => $message,
        ];

        parent::__construct($data, 500);
    }

}
