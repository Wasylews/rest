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
        $request = $this->getRequest();
        echo $this->router->handle($request);
    }

    private function getRequest() {
        return new http\Request($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
    }
}