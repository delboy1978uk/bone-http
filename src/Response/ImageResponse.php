<?php

namespace Bone\Http\Response;

use Barnacle\Exception\NotFoundException;
use Bone\Http\Response;
use Bone\Http\Stream;

class ImageResponse extends Response
{
    public function __construct(string $path)
    {
        if (\file_exists($path)) {
            $mimeType = $this->getMimeType($path);
            $body = \file_get_contents($path);
            $stream = new Stream('php://memory', 'r+');
            $stream->write($body);
            $headers = ['Content-Type' => $mimeType];
            parent::__construct($stream, 200, $headers);
        } else {
            throw new NotFoundException($path . ' not found');
        }
    }

    private function getMimeType(string $path): string
    {
        $finfo = \finfo_open(FILEINFO_MIME);
        $mimeType = \finfo_file($finfo, $path);
        \finfo_close($finfo);

        return $mimeType;
    }
}
