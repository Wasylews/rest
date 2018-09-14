<?php

namespace core\web;


class Router {

    private $routes = [];

    public function get($route, $controller) {
        $this->routes[$route] = $controller;
    }

    public function post($route, $controller) {
        $this->routes[$route] = $controller;
    }

    public function put($route, $controller) {
        $this->routes[$route] = $controller;
    }

    public function delete($route, $controller) {
        $this->routes[$route] = $controller;
    }

    public function handle(\core\http\Request $request) {
        foreach ($this->routes as $route) {
            if (preg_match($route, $request->getUrl())) {
                return $this->callHandler($route, $request);
            }
        }
        return new \core\http\Response(404, 'Not found');
    }

    private function callHandler($route, \core\http\Request $request) {
        $controller = $this->routes[$route];
        switch ($request->getMethod()) {
            case \core\http\Request::HTTP_GET:
                return $controller->get($request);
            case \core\http\Request::HTTP_POST:
                return $controller->post($request);
            case \core\http\Request::HTTP_PUT:
                return $controller->put($request);
            case \core\http\Request::HTTP_DELETE:
                return $controller->delete($request);
        }
    }
}