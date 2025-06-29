<?php

declare(strict_types=1);

namespace Bone\Http;

use Barnacle\Container;

interface MiddlewareRegistrationInterface
{
    /**
     * Create your middleware and return them as an array to get
     * them added to the container.
     * If you need your middleware added globally, implement
     * GlobalMiddlewareRegistrationInterface instead, where you can also
     * return the names of the middlewares created that you want added
     * @param Container $c
     * @return array
     */
    public function getMiddleware(Container $c): array;
}
