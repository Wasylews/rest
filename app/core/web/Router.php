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
        foreach ($this->routes as $route => $controller) {
            $parameters = UrlMatcher::match($route, $request->getUrl());
            if ($parameters != null) {
                $request->setParameters($parameters);
                return $this->callHandler(new $controller, $request);
            }
        }
        return new \core\http\Response(404);
    }

    private function callHandler(\core\http\Controller $controller, \core\http\Request $request) {
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
        return new \core\http\Response(\core\http\Response::HTTP_METHOD_NOT_ALLOWED);
    }
}