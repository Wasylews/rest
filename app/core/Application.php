<?php

namespace core;


class Application {

    /**
     * @var web\Router
     */
    private $router;

    public function __construct(web\Router $router) {
        $this->router = $router;
    }

    public function run() {
        $request = http\Request::fromGlobals();
        $response = $this->router->handle($request);
        $this->sendResponse($response);
    }

    private function sendResponse(http\Response $response) {
        foreach ($response->getHeaders() as $key => $value) {
            header("$key: $value", false, $response->getStatusCode());
        }
        header($response->getStatus(), true, $response->getStatusCode());
        echo $response->getContent();
    }
}