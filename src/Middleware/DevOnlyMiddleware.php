<?php

declare(strict_types=1);

namespace Bone\Http\Middleware;

use Bone\Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use function getenv;

class DevOnlyMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (getenv('APPLICATION_ENV') === 'development') {
            return $handler->handle($request);
        }

        throw new Exception(Exception::LOST_AT_SEA) ;
    }
}
