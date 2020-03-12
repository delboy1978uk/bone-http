<?php

namespace Barnacle\Tests;

use Barnacle\Container;
use Bone\Firewall\FirewallPackage;
use Bone\Firewall\RouteFirewall;
use Bone\Http\Middleware\HalEntity;
use Bone\Router\Router;
use BoneTest\FakeController;
use BoneTest\FakeMiddleware;
use BoneTest\FakeRequestHandler;
use Codeception\TestCase\Test;
use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\Uri;
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
        $request = $request->withBody(json_encode([
            'id' => 1320,
            'date' => '2020-04-06',
            'location' => 'Arbroath',
        ]));
        $request = $request->withUri(new Uri('/declaration/1320'))
        $response = $middleware->process($request, $handler);
        $body = $response->getBody()->getContents();
        $this->assertEquals('xxx', $body);
    }
}


