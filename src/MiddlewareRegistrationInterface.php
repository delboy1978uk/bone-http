<?php

namespace Bone\Http;

use Barnacle\Container;
use Bone\Http\Middleware\Stack;

interface MiddlewareRegistrationInterface
{
    /**
     * Create your middleware and return them as an array to get
     * them added to the container.
     * If you need your middleware added globally, implement
     * GlobalMiddlewareRegistrationInterface instead, where you can also
     * return the names of the middlewares created that you want added
     * @param Container $container
     * @return array
     */
    public function getMiddleware(Container $container): array;
}