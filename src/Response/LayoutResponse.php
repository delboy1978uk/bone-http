<?php

namespace Bone\Http\Response;

class LayoutResponse extends HtmlResponse
{
    /** @var string $layout */
    private $layout;

    /**
     * LayoutResponse constructor.
     * @param $html
     * @param string $layout
     * @param int $status
     * @param array $headers
     */
    public function __construct($html, string $layout, int $status = 200, array $headers = [])
    {
        parent::__construct($html, $status, $headers);
        $this->layout = $layout;
    }

    /**
     * @return string
     */
    public function getLayout(): string
    {
        return $this->layout;
    }
}