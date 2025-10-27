<?php

declare(strict_types=1);

namespace Bone\Http\Response\Json\Error;

use Bone\Http\Response\JsonResponse;

class BadRequestResponse extends JsonResponse
{
    public function __construct(string|array $message)
    {
        $data = [
            'reason_phrase' => $message,
        ];

        parent::__construct($data, 400);
    }

}
