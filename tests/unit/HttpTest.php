<?php

namespace BoneTest\Http;

use Barnacle\Container;
use Bone\Firewall\FirewallPackage;
use Bone\Firewall\RouteFirewall;
use Bone\Http\Middleware\HalCollection;
use Bone\Http\Middleware\HalEntity;
use Bone\Http\Middleware\JsonParse;
use Bone\Http\Middleware\Stack;
use Bone\Http\Response\HtmlResponse;
use Bone\Http\Response\LayoutResponse;
use Bone\Http\RouterInterface;
use League\Route\Router;
use BoneTest\Http\AnotherFakeRequestHandler;
use BoneTest\Http\FakeController;
use BoneTest\Http\FakeMiddleware;
use BoneTest\Http\FakeRequestHandler;
use Codeception\Test\Unit;
use InvalidArgumentException;
use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\Stream;
use Laminas\Diactoros\Uri;
use League\Route\Http\Exception\NotFoundException;
use League\Route\Route;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class HttpTest extends Unit
{
    /** @var Container */
    protected $container;

    protected function _before()
    {
        $this->container = $c = new Container();
    }

    protected function _after()
    {
        unset($this->container);
    }

    public function testHalEntity()
    {
        $middleware = new HalEntity();
        $handler = new FakeRequestHandler();
        $request = new ServerRequest();
        $request = $request->withUri(new Uri('/declaration/1320'));
        $response = $middleware->process($request, $handler);
        $response->getBody()->rewind();
        $body = $response->getBody()->getContents();
        $this->assertEquals('{"_links":{"self":{"href":":\/\/\/declaration\/1320"}},"id":1320,"date":"2020-04-06","location":"Arbroath"}', $body);
    }

    public function testJsonParse()
    {
        $stream = new Stream('php://memory', 'a+');
        $stream->write('{"testing":"123","hello":"hi","pass":"ok"}');
        $stream->rewind();
        $middleware = new JsonParse();
        $handler = new JsonParseRequestHandler($this);
        $request = new ServerRequest([], [], '/testing-json-request-body', null, $stream, [
            'Content-Type' => 'applicastion/json',
        ], [], ['page' => 2]);
        $response = $middleware->process($request, $handler);
    }

    public function testHalCollection()
    {
        $middleware = new HalCollection(1);
        $handler = new AnotherFakeRequestHandler();
        $request = new ServerRequest();
        $request = $request->withUri(new Uri('/declarations'));
        $response = $middleware->process($request, $handler);
        $response->getBody()->rewind();
        $body = $response->getBody()->getContents();
        $this->assertEquals('{"_links":{"self":{"href":":\/\/\/declarations"},"first":{"href":":\/\/\/declarations"},"next":{"href":":\/\/\/declarations?page=2"},"last":{"href":":\/\/\/declarations?page=2"}},"_embedded":[{"id":1320,"date":"2020-04-06","location":"Arbroath","_links":{"self":{"href":":\/\/\/declarations\/1320"}}},{"id":2014,"date":"2014-09-18","location":"Glasgow","_links":{"self":{"href":":\/\/\/declarations\/2014"}}}],"total":2}', $body);
    }


    public function testHalCollectionPage2()
    {
        $middleware = new HalCollection(1);
        $handler = new AnotherFakeRequestHandler();
        $uri = new Uri('/declarations');
        $request = new ServerRequest([], [], $uri, null, 'php://input', [], [], ['page' => 2]);
        $response = $middleware->process($request, $handler);
        $response->getBody()->rewind();
        $body = $response->getBody()->getContents();
        $this->assertEquals('{"_links":{"self":{"href":":\/\/\/declarations"},"first":{"href":":\/\/\/declarations"},"prev":{"href":":\/\/\/declarations?page=1"},"last":{"href":":\/\/\/declarations?page=2"}},"_embedded":[{"id":1320,"date":"2020-04-06","location":"Arbroath","_links":{"self":{"href":":\/\/\/declarations\/1320"}}},{"id":2014,"date":"2014-09-18","location":"Glasgow","_links":{"self":{"href":":\/\/\/declarations\/2014"}}}],"total":2}', $body);
    }


    public function testMiddlewareStack()
    {
        $router = new class extends Router implements RouterInterface {};
        $stack = new Stack($router);
        $middleware = new FakeMiddleware();
        $stack->addMiddleWare($middleware);
        $stack->prependMiddleWare(clone $middleware);
        $this->expectException(NotFoundException::class);
        $stack->handle(new ServerRequest());
    }


    public function testHtmlResponse()
    {
        $stream = new Stream('php://temp', 'wb+');
        $response = new HtmlResponse($stream);
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->expectException(InvalidArgumentException::class);
        new HtmlResponse(new FakeController());
    }

    public function testLayoutResponse()
    {
        $response = new LayoutResponse( 'content', 'blah');
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals('blah', $response->getLayout());
        $this->assertEquals('content', $response->getBody()->getContents());
    }
}


