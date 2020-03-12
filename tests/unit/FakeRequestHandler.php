<?php declare(strict_types=1);

namespace BoneTest;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class FakeRequestHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new JsonResponse([
            'id' => 1320,
            'date' => '2020-04-06',
            'location' => 'Arbroath',
        ]);
    }
}