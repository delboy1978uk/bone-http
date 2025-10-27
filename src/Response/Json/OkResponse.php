<?php

declare(strict_types=1);

namespace Bone\Http\Response\Json;

use Bone\Http\Response\JsonResponse;

class OkResponse extends JsonResponse
{
    public function __construct(string $message)
    {
        $data = [
            'data' => $message,
        ];

        parent::__construct($data, 200);
    }
}

