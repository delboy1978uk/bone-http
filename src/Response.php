<?php

namespace Bone\Http;

use Bone\Server\Traits\HasAttributesTrait;
use Laminas\Diactoros\Response as BaseResponse;

class Response extends BaseResponse
{
    use HasAttributesTrait;
}