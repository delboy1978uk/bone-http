<?php

namespace Bone\Http;

use Barnacle\Container;
use Bone\Http\Middleware\Stack;

interface MiddlewareRegistrationInterface
{
    /**
     * @param Container $container
     * @return array
     */
    public function getMiddleware(Container $container): array;
}