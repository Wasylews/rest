<?php

declare(strict_types=1);

namespace Core\Http;


class XmlResponse extends Response {

    public function __construct(int $statusCode, string $content)
    {
        parent::__construct($statusCode, $content);
        $this->setContentType('application/xml');
    }
}