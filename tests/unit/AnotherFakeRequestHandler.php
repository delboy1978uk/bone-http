<?php declare(strict_types=1);

namespace BoneTest\Http;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AnotherFakeRequestHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new JsonResponse([
            '_embedded' => [
                [
                    'id' => 1320,
                    'date' => '2020-04-06',
                    'location' => 'Arbroath',
                ], [
                    'id' => 2014,
                    'date' => '2014-09-18',
                    'location' => 'Glasgow',
                ],],
            'total' => 2
        ]);
    }
}