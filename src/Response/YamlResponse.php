<?php

declare(strict_types=1);

namespace Bone\Http\Response;

use Bone\Http\Response;
use Bone\Http\Stream;

class YamlResponse extends Response
{
    public function __construct(string $body)
    {
        $stream = new Stream('php://memory', 'r+');
        $stream->write($body);
        $headers = ['Content-Type' => 'application/yaml'];
        parent::__construct($stream, 200, $headers);
    }
}
