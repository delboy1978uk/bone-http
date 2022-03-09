<?php

namespace Bone\Http\Middleware;

use Bone\Http\RouterInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Stack implements RequestHandlerInterface
{
    /** @var MiddlewareInterface[] $middleware */
    private $middleware = [];

    /** @var RouterInterface $router */
    private $router;

    /**
     * Stack constructor.
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @param MiddlewareInterface $middleware
     */
    public function addMiddleWare(MiddlewareInterface $middleware): void
    {
        $this->middleware[] = $middleware;
    }

    /**
     * @param MiddlewareInterface $middleware
     */
    public function prependMiddleWare(MiddlewareInterface $middleware): void
    {
        array_unshift($this->middleware, $middleware);
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $middleware = array_shift($this->middleware);

        if ($middleware === null) {
            return $this->router->handle($request);
        }

        return $middleware->process($request, $this);
    }
}
