<?php

declare(strict_types=1);

namespace Bone\Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use function json_decode;

class JsonParse implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $json = $request->getBody()->getContents();
        $data = json_decode($json, true);
        $request = $request->withParsedBody($data);

        return $handler->handle($request);
    }
}
