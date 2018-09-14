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

    public static function fromGlobals() {
        return new Request($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
    }

    public function getUrl() {
        return $this->url;
    }

    public function getMethod() {
        return $this->method;
    }
}