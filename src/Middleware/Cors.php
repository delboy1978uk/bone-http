<?php

declare(strict_types=1);

namespace Bone\Http\Middleware;

use Bone\Http\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class Cors implements MiddlewareInterface
{
    public function __construct(
        private array $allowedOrigins = ['*'],
        private array $allowedMethods = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],
        private array $allowedHeaders = [
            'Content-Type',
            'Accept',
            'Authorization',
            'X-Requested-With',
            'X-CSRF-Token',
            'Origin',
        ],
        private array $exposedHeaders = ['Authorization', 'Content-Location'],
        private bool $allowCredentials = false,
        private int $maxAge = 86400, // 24 hours
    ) {
    }

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        // Always handle preflight OPTIONS requests
        if ($request->getMethod() === 'OPTIONS') {
            return $this->createPreflightResponse();
        }

        // Normal request → let it go through, then add CORS headers
        $response = $handler->handle($request);

        return $this->addCorsHeaders($response, $request);
    }

    private function createPreflightResponse(): ResponseInterface
    {
        $response = new Response(); // or any PSR-7 response factory

        return $this->addCorsHeaders($response, null)
            ->withHeader('Content-Length', '0')
            ->withStatus(204);
    }

    private function addCorsHeaders(
        ResponseInterface $response,
        ?ServerRequestInterface $request
    ): ResponseInterface {
        $origin = $request?->getHeaderLine('Origin') ?? '';

        // Handle allowed origins
        $allowedOrigin = $this->getAllowedOrigin($origin);

        $response = $response
            ->withHeader('Access-Control-Allow-Origin', $allowedOrigin)
            ->withHeader('Vary', 'Origin'); // very important when using specific origins

        if ($this->allowCredentials && $allowedOrigin !== '*') {
            $response = $response->withHeader('Access-Control-Allow-Credentials', 'true');
        }

        // Only add these on preflight or when requested
        if ($request === null || $request->getMethod() === 'OPTIONS') {
            $response = $response
                ->withHeader('Access-Control-Allow-Methods', implode(', ', $this->allowedMethods))
                ->withHeader('Access-Control-Allow-Headers', implode(', ', $this->allowedHeaders))
                ->withHeader('Access-Control-Max-Age', (string) $this->maxAge);
        }

        if ($this->exposedHeaders !== []) {
            $response = $response->withHeader(
                'Access-Control-Expose-Headers',
                implode(', ', $this->exposedHeaders)
            );
        }

        return $response;
    }

    private function getAllowedOrigin(string $origin): string
    {
        if (in_array('*', $this->allowedOrigins, true)) {
            return '*';
        }

        if ($origin === '') {
            return '*'; // or return '' depending on your policy
        }

        // Check exact match or with protocol variation
        foreach ($this->allowedOrigins as $allowed) {
            if ($this->originMatches($origin, $allowed)) {
                return $origin;
            }
        }

        // No match → most restrictive: empty string (browser will reject)
        return '';
    }

    private function originMatches(string $actual, string $allowed): bool
    {
        if ($allowed === $actual) {
            return true;
        }

        // Optional: allow https://example.com when you have example.com in list
        $actualWithoutProtocol = preg_replace('#^https?://#i', '', $actual);
        if ($allowed === $actualWithoutProtocol) {
            return true;
        }

        return false;
    }
}
