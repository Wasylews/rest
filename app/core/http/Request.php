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
    private $parameters;

    public function __construct($method, $url) {
        $this->method = $method;
        $this->url = $url;
    }

    public static function fromGlobals() {
        $request = new Request($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
        $request->setBody($_POST);
        $request->setHeaders(getallheaders());
        return $request;
    }

    public function getUrl() {
        return $this->url;
    }

    public function getMethod() {
        return $this->method;
    }

    public function setHeaders($headers) {
        $this->headers = $headers;
    }

    public function getHeaders(): array {
        return $this->headers;
    }

    public function setBody($body) {
        $this->body = $body;
    }

    public function getBody(): array {
        return $this->body;
    }

    public function setParameters(array $parameters) {
        $this->parameters = $parameters;
    }

    public function getParameters(): array {
        return $this->parameters;
    }

    public function getParameter($name) {
        return $this->parameters[$name];
    }
}