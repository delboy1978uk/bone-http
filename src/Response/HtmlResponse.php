<?php

declare(strict_types=1);

namespace Bone\Http\Response;

use Bone\Http\Response;
use InvalidArgumentException;
use Laminas\Diactoros\Response\InjectContentTypeTrait;
use Laminas\Diactoros\Stream;
use Psr\Http\Message\StreamInterface;
use function get_class;
use function gettype;
use function is_object;

class HtmlResponse extends Response
{
    use InjectContentTypeTrait;

    public function __construct($html, int $status = 200, array $headers = [])
    {
        parent::__construct(
            $this->createBody($html),
            $status,
            $this->injectContentType('text/html; charset=utf-8', $headers)
        );
    }

    private function createBody($html) : StreamInterface
    {
        if ($html instanceof StreamInterface) {
            return $html;
        }

        if (! is_string($html)) {
            throw new InvalidArgumentException(sprintf(
                'Invalid content (%s) provided to %s',
                (is_object($html) ? get_class($html) : gettype($html)),
                __CLASS__
            ));
        }

        $body = new Stream('php://temp', 'wb+');
        $body->write($html);
        $body->rewind();

        return $body;
    }
}
