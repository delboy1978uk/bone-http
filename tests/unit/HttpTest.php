<?php

namespace Barnacle\Tests;

use Barnacle\Container;
use Bone\Firewall\FirewallPackage;
use Bone\Firewall\RouteFirewall;
use Bone\Http\Middleware\HalCollection;
use Bone\Http\Middleware\HalEntity;
use Bone\Http\Middleware\Stack;
use Bone\Router\Router;
use BoneTest\AnotherFakeRequestHandler;
use BoneTest\FakeController;
use BoneTest\FakeMiddleware;
use BoneTest\FakeRequestHandler;
use Codeception\TestCase\Test;
use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\Stream;
use Laminas\Diactoros\Uri;
use League\Route\Http\Exception\NotFoundException;
use League\Route\Route;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class HttpTest extends Test
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
        $stack = new Stack(new Router());
        $middleware = new FakeMiddleware();
        $stack->addMiddleWare($middleware);
        $stack->prependMiddleWare(clone $middleware);
        $this->expectException(NotFoundException::class);
        $stack->handle(new ServerRequest());
    }
}


