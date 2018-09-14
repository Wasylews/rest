<?php

namespace Core\Web;

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

    public function handle(\Core\Http\Request $request) {
        foreach ($this->routes as $route => $controller) {
            $parameters = UrlMatcher::match($route, $request->getUrl());
            if ($parameters != null) {
                $request->setParameters($parameters);
                return $this->callHandler(new $controller, $request);
            }
        }
        return new \Core\Http\Response(404);
    }

    private function callHandler(\Core\Http\Controller $controller, \Core\Http\Request $request) {
        switch ($request->getMethod()) {
            case \Core\Http\Request::HTTP_GET:
                return $controller->get($request);
            case \Core\Http\Request::HTTP_POST:
                return $controller->post($request);
            case \Core\Http\Request::HTTP_PUT:
                return $controller->put($request);
            case \Core\Http\Request::HTTP_DELETE:
                return $controller->delete($request);
        }
        return new \Core\Http\Response(\Core\Http\Response::HTTP_METHOD_NOT_ALLOWED);
    }
}