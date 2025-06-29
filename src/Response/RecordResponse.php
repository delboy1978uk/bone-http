<?php

declare(strict_types=1);

namespace Bone\Http\Response;

use Bone\Application;
use function array_merge;

class RecordResponse extends JsonResponse
{
    public function __construct($entity, int $status = 200, array $headers = [])
    {
        $uri = Application::ahoy()->getGlobalRequest()->getUri();

        $hal = [
            '_links' => [
                'self' => [
                    'href' => $uri->getScheme() . '://' . $uri->getHost() . $uri->getPath(),
                ]
            ],
        ];

        $data = array_merge($hal, $entity->toArray());
        parent::__construct($data, $status, $headers);
    }
}
