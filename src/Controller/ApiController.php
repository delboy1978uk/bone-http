<?php

declare(strict_types=1);

namespace Bone\Http\Controller;

use Bone\Application;
use Bone\Contracts\Service\RestServiceInterface;
use Bone\Http\Response\CollectionResponse;
use Bone\Http\Response\EmptyResponse;
use Bone\Http\Response\RecordResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class ApiController
{
    private RestServiceInterface $service;

    public function __construct()
    {
        $container = Application::ahoy()->getContainer();
        $serviceClass = $this->getServiceClass();
        $this->service = $container->get($serviceClass);
    }

    abstract public function getServiceClass(): string;

    public function index(ServerRequestInterface $request): CollectionResponse
    {
        return new CollectionResponse($this->service->index($request));
    }

    public function create(ServerRequestInterface $request): ResponseInterface
    {
        return new RecordResponse($this->service->post($request->getParsedBody()), 201);
    }

    public function read(ServerRequestInterface $request): ResponseInterface
    {
        return new RecordResponse($this->service->get($request));
    }

    public function update(ServerRequestInterface $request): ResponseInterface
    {
        return new RecordResponse($this->service->patch($request));
    }

    public function delete(ServerRequestInterface $request): ResponseInterface
    {
        $this->service->delete($request);

        return new EmptyResponse();
    }
}
