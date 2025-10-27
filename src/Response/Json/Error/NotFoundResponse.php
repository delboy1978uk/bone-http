<?php

declare(strict_types=1);

namespace Bone\Http\Response\Json\Error;

use Bone\Http\Response\JsonResponse;

class NotFoundResponse extends JsonResponse
{
    public function __construct(string $message)
    {
        $data = [
            'reason_phrase' => $message,
        ];

        parent::__construct($data, 404);
    }

}
