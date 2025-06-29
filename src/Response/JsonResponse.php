<?php

declare(strict_types=1);

namespace Bone\Http\Response;

use Del\Form\Traits\HasAttributesTrait;
use Laminas\Diactoros\Response\JsonResponse as BaseJsonResponse;

class JsonResponse extends BaseJsonResponse
{
    use HasAttributesTrait;
}
