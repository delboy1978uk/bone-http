<?php

declare(strict_types=1);

namespace Bone\Http\Response\Json;

use Bone\Http\Response\EmptyResponse;

class CreatedResponse extends EmptyResponse
{
    public function __construct()
    {
        parent::__construct(201);
    }
}

