<?php

declare(strict_types=1);

namespace Bone\Http\Response;

use Bone\Contracts\Collection\ApiCollectionInterface;

class CollectionResponse extends JsonResponse
{
    public function __construct(ApiCollectionInterface $collection, int $status = 200, array $headers = [])
    {
        $uri = $collection->getUri();
        $pageCount = $collection->getTotalPages();
        $page = $collection->getPage();
        $hal = [
            '_links' => [
                'self' => [
                    'href' => $uri->getScheme() . '://' . $uri->getHost() . $uri->getPath(),
                ],
                'first' => [
                    'href' => $uri->getScheme() . '://' . $uri->getHost() . $uri->getPath(),
                ],
            ],
        ];

        if ($page !== 1) {
            $hal['_links']['prev'] = [
                'href' => $uri->getScheme() . '://' . $uri->getHost() . $uri->getPath() . '?page=' . ($page - 1),
            ];
        }

        if ($page !== $pageCount) {
            $hal['_links']['next'] = [
                'href' => $uri->getScheme() . '://' . $uri->getHost() . $uri->getPath() . '?page=' . ($page + 1),
            ];
        }

        $hal['_links']['last'] = [
            'href' => $uri->getScheme() . '://' . $uri->getHost() . $uri->getPath() . '?page=' . $pageCount,
        ];

        foreach ($collection as $entity) {
            $entityData = $entity->toArray();
            $entityData ['_links'] = [
                'self' => [
                    'href' => $uri->getScheme() . '://' . $uri->getHost() . $uri->getPath() . '/' . $entity->getId(),
                ]
            ];
            $hal['_embedded'][] = $entityData;
            /** @todo strip based on visibility (read, create, update) */
        }

        foreach ($hal['_embedded'] as $key => $value) {
            $hal['_embedded'][$key]['_links'] = [
                'self' => [
                    'href' => $uri->getScheme() . '://' . $uri->getHost() . $uri->getPath() . '/' . $value['id'],
                ],
            ];
        }

        parent::__construct($hal, $status, $headers);
    }
}
