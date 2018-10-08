<?php

declare(strict_types=1);

namespace Core\Http;


class Request {

    const HTTP_GET = 'GET';
    const HTTP_POST = 'POST';
    const HTTP_PUT = 'PUT';
    const HTTP_DELETE = 'DELETE';

    private $url;
    private $method;
    /**
     * @filed string[] $headers
    */
    private $headers;
    /**
     * @field string @body raw POST data
    */
    private $body;
    /**
     * @field string[] $parameters REST parameters
    */
    private $parameters;

    public function __construct(string $method, string $url) {
        $this->method = $method;
        $this->url = $url;
    }

    public function getUrl(): string {
        return $this->url;
    }

    public function getMethod(): string {
        return $this->method;
    }

    public function setHeaders(array $headers) {
        $this->headers = $headers;
    }

    public function getHeaders(): array {
        return $this->headers;
    }

    public function setBody(string $body) {
        $this->body = $body;
    }

    public function getBody(): string {
        return $this->body;
    }

    public function setParameters(array $parameters) {
        $this->parameters = $parameters;
    }

    public function getParameters(): array {
        return $this->parameters;
    }

    public function getParameter(string $name): string {
        return $this->parameters[$name];
    }

    public function hasParameter(string $name): bool {
        return array_key_exists($name, $this->parameters);
    }
}