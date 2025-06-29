<?php

declare(strict_types=1);

namespace Bone\Http;

use Barnacle\Container;

interface GlobalMiddlewareRegistrationInterface extends MiddlewareRegistrationInterface
{
    /**
     * Return an array of class names already created in getMiddleware
     * in order to add them to the global middleware stack
     * The container should only really be used for doing $c->has(Something::class)
     * e.g. if a middleware is disabled in package config php file, like i18n for instance
     * @return array
     */
    public function getGlobalMiddleware(Container $c): array;
}
