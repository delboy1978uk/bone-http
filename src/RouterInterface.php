<?php

namespace Bone\Http;

use League\Route\Route;
use League\Route\RouteGroup;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface RouterInterface
{
    public function getRoutes(): array;
    public function removeRoute(Route $routeToRemove): void;
    public function handle(ServerRequestInterface $request): ResponseInterface;
    public function getNamedRoute(string $name): Route;
    public function addPatternMatcher(string $alias, string $regex): self;
    public function group(string $prefix, callable $group): RouteGroup;
    public function map(string $method, string $path, $handler): Route;

}
