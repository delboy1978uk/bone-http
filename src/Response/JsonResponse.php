<?php

declare(strict_types=1);

namespace Bone\Http\Response;

use Barnacle\Exception\NotFoundException;
use Bone\Http\Response;
use Bone\Http\Stream;
use Del\Form\Traits\HasAttributesTrait;
use Laminas\Diactoros\Response\JsonResponse as BaseJsonResponse;

class JsonResponse extends BaseJsonResponse
{
    use HasAttributesTrait;
}
