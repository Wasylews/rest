<?php

declare(strict_types=1);

namespace Core;


class Application {

    /**
     * @var Web\Router
     */
    private $router;

    public function __construct(Web\Router $router) {
        $this->router = $router;
    }

    public function run() {
        $request = Http\Request::fromGlobals();
        $response = $this->router->handle($request);
        $this->sendResponse($response);
    }

    private function sendResponse(Http\Response $response) {
        foreach ($response->getHeaders() as $key => $value) {
            header("$key: $value", false, $response->getStatusCode());
        }
        header($response->getStatus(), true, $response->getStatusCode());
        echo $response->getContent();
    }
}