<?php

declare(strict_types=1);

namespace Bone\Http;

use Bone\Server\Traits\HasAttributesTrait;
use Laminas\Diactoros\Response as BaseResponse;

class Response extends BaseResponse
{
    use HasAttributesTrait;
}
