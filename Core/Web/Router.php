<?php

declare(strict_types=1);

namespace Core\Web;

class Router {

    /**
     * @var \Core\Di\DependencyContainer
    */
    private $container;
    private $routes = [];

    public function get(string $route, string $controller) {
        $this->routes[$route] = $controller;
    }

    public function post(string $route, string $controller) {
        $this->routes[$route] = $controller;
    }

    public function put(string $route, string $controller) {
        $this->routes[$route] = $controller;
    }

    public function delete(string $route, string $controller) {
        $this->routes[$route] = $controller;
    }

    public function handle(\Core\Http\Request $request): \Core\Http\Response {
        foreach ($this->routes as $route => $controller) {
            $parameters = UrlMatcher::match($route, $request->getUrl());
            if ($parameters !== null) {
                $request->setParameters($parameters);
                return $this->callHandler($this->container->get($controller), $request);
            }
        }
        return new \Core\Http\Response(404);
    }

    private function callHandler(\Core\Http\AbstractController $controller, \Core\Http\Request $request): \Core\Http\Response {
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

    public function setContainer(\Core\Di\DependencyContainer $container) {
        $this->container = $container;
    }
}