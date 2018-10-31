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

    /**
     * @var \Core\Bootstrap\BundleInterface[]
    */
    protected $bundles = [];

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

    protected function addBundle(BundleInterface $bundle) {
        array_push($this->bundles, $bundle);
    }

    public function bootstrap() {
        $this->initContainer();
        $this->initRouting();
        $this->initBundles();
    }

    public function getContainer(): \Core\Di\DependencyContainer {
        return $this->container;
    }

    /**
     * Dependency container initialization.
     * User can override this method to supply custom container
    */
    protected function initContainer() {
        $this->container = new \Core\Di\DependencyContainer();
        $this->container->bind(\Core\Http\Request::class, \Core\Di\Provider\RequestProvider::class);
        $this->container->bindSingleton(\Core\Web\Router::class);
        $this->bindServices();
    }

    /**
     * Web router initialization.
     * User can override this method for using custom router
    */
    protected function initRouting() {
        $this->router = $this->container->get(\Core\Web\Router::class);
        $this->router->setContainer($this->container);
    }

    private function initBundles() {
        $this->loadBundles();
        foreach ($this->bundles as $bundle) {
            $bundle->bindServices($this->container);
            $bundle->initRoutes($this->router);
        }
    }

    /**
     * Method for loading user dependencies into container
    */
    protected abstract function bindServices();

    protected abstract function loadBundles();
}