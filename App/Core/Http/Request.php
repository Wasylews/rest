<?php

namespace Core\Http;


class Request {

    const HTTP_GET = 'GET';
    const HTTP_POST = 'POST';
    const HTTP_PUT = 'PUT';
    const HTTP_DELETE = 'DELETE';

    private $url;
    private $method;
    private $headers;
    private $body;
    private $parameters;

    public function __construct(string $method, string $url) {
        $this->method = $method;
        $this->url = $url;
    }

    public static function fromGlobals(): Request {
        $request = new Request($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
        $request->setBody($_POST);
        $request->setHeaders(getallheaders());
        return $request;
    }

    public function getUrl(): string {
        return $this->url;
    }

    public function getMethod(): string {
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

    public function getParameter($name): string {
        return $this->parameters[$name];
    }
}