<?php

declare(strict_types=1);

namespace Core\Bootstrap;


abstract class AbstractApplication {

    /**
     * @var \Core\Web\Router
     */
    protected $router;

    /**
     * @var \Core\Di\DependencyContainer
     */
    protected $container;

    public function run() {
        $this->bootstrap();
        $request = $this->container->get(\Core\Http\Request::class);
        $response = $this->router->handle($request);
        $this->sendResponse($response);
    }

    private function sendResponse(\Core\Http\Response $response) {
        foreach ($response->getHeaders() as $key => $value) {
            header("$key: $value", false, $response->getStatusCode());
        }
        header($response->getStatus(), true, $response->getStatusCode());
        echo $response->getContent();
    }

    public function bootstrap() {
        $this->initContainer();
        $this->initRouting();
    }

    public function getContainer(): \Core\Di\DependencyContainer {
        return $this->container;
    }

    /**
     * Dependency container initialization.
     * User can override this method to supply his own container
    */
    protected function initContainer() {
        $this->container = new \Core\Di\DependencyContainer();
        $this->container->bind(\Core\Http\Request::class, \Core\Di\Provider\RequestProvider::class);
        $this->container->bindSingleton(\Core\Web\Router::class);
        $this->registerServices();
    }

    /**
     * Web router initialization.
     * User can override this method for using his own router
    */
    protected function initRouting() {
        $this->router = $this->container->get(\Core\Web\Router::class);
        $this->router->setContainer($this->container);
        $this->initRoutes();
    }

    /**
     * Method for loading user dependencies into container
    */
    protected abstract function registerServices();

    /**
     * Method for app routing initialization
    */
    protected abstract function initRoutes();
}