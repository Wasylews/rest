<?php

namespace core\http;


class Request {

    const HTTP_GET = "GET";
    const HTTP_POST = "POST";
    const HTTP_PUT = "PUT";
    const HTTP_DELETE = "DELETE";

    private $url;
    private $method;
    private $headers;
    private $body;

    public function __construct($method, $url, $body = [], $headers = []) {
        $this->method = $method;
        $this->url = $url;
        $this->headers = $headers;
        $this->body = $body;
    }

    public static function fromGlobals() {
        return new Request($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI'], $_POST, getallheaders());
    }

    public function getUrl() {
        return $this->url;
    }

    public function getMethod() {
        return $this->method;
    }

    public function getHeaders(): array {
        return $this->headers;
    }

    public function getBody(): array {
        return $this->body;
    }
}