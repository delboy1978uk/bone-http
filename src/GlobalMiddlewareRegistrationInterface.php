<?php

namespace Bone\Http;

use Barnacle\Container;

interface GlobalMiddlewareRegistrationInterface extends MiddlewareRegistrationInterface
{
    /**
     * Return an array of class names already created in getMiddleware
     * in order to add them to the global middleware stack
     * @return array
     */
    public function addGlobalMiddleware(): array;
}