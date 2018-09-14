<?php

namespace core\http;


class Request {

    const HTTP_GET = "GET";
    const HTTP_POST = "POST";
    const HTTP_PUT = "PUT";
    const HTTP_DELETE = "DELETE";

    private $url;
    private $method;

    public function __construct($method, $url) {
        $this->method = $method;
        $this->url = $url;
    }

    public function getUrl() {
        return $this->url;
    }

    public function getMethod() {
        return $this->method;
    }
}