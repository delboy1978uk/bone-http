<?php

namespace Bone\Http;

use Barnacle\Container;
use Bone\Http\Middleware\Stack;

interface MiddlewareAwareInterface extends MiddlewareRegistrationInterface
{
    /**
     * @deprecated please use MiddlewareRegistrationInterface
     *             and just return an array of your Middleware
     *             instead of adding to the container
     * @param Stack $stack
     * @param Container $container
     */
    public function addMiddleware(Stack $stack, Container $container): void;
}