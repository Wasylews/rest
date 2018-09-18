<?php

declare(strict_types=1);

namespace Core\Http;

/**
 * Http response with json content
*/
class JsonResponse extends Response {

    public function __construct(int $statusCode, $content)
    {
        parent::__construct($statusCode, $content);
        $this->setContentType('application/json');
    }
}