<?php

declare(strict_types=1);

namespace Bone\Http\Middleware;

use Bone\Http\RouterInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use function array_shift;
use function array_unshift;

class Stack implements RequestHandlerInterface
{
    /** @var MiddlewareInterface[] $middleware */
    private array $middleware = [];
    private RouterInterface $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function addMiddleWare(MiddlewareInterface $middleware): void
    {
        $this->middleware[] = $middleware;
    }

    public function prependMiddleWare(MiddlewareInterface $middleware): void
    {
        array_unshift($this->middleware, $middleware);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $middleware = array_shift($this->middleware);

        if ($middleware === null) {
            return $this->router->handle($request);
        }

        return $middleware->process($request, $this);
    }
}
