<?php declare(strict_types=1);

namespace BoneTest\Http;

use Bone\Http\Response\HtmlResponse;
use Codeception\Test\Unit;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class JsonParseRequestHandler implements RequestHandlerInterface
{
    /** @var Unit $tester */
    private $tester;

    public function __construct(Unit $test)
    {
        $this->tester = $test;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $post = $request->getParsedBody();
        $this->tester->assertCount(3, $post);

        return new HtmlResponse('hooray');
    }
}
