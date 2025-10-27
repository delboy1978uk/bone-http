<?php

declare(strict_types=1);

namespace Bone\Http\Response\Json;

use Bone\Http\Response\JsonResponse;

class CreatedResponse extends JsonResponse
{
    public function __construct(array|string|null $body = null)
    {
        $data = [];

        if ($body) {
            $data = [
                'data' => $body
            ];
        }

        parent::__construct($data, 201);
    }
}

