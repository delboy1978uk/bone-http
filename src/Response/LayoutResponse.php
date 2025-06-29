<?php

declare(strict_types=1);

namespace Bone\Http\Response;

class LayoutResponse extends HtmlResponse
{
    private  string$layout;

    public function __construct($html, string $layout, int $status = 200, array $headers = [])
    {
        parent::__construct($html, $status, $headers);
        $this->layout = $layout;
    }

    public function getLayout(): string
    {
        return $this->layout;
    }
}
