<?php
/**
 * User: delboy1978uk
 * Date: 26/10/2025
 * Time: 18:12
 */

namespace Bone\Http\Response\Json;

use Bone\Http\Response\JsonResponse;

class OkResponse extends JsonResponse
{
    public function __construct(string $message)
    {
        $data = [
            'status_code' => 200,
            'reason_phrase' => $message,
        ];

        parent::__construct($data, 200);
    }
}

