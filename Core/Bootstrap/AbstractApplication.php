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
     * @var \Core\Serialization\Serializer
    */
    protected $serializer;

    public function run() {
        $this->bootstrap();
        $request = \Core\Http\Request::fromGlobals();
        $response = $this->router->handle($request);
        $this->sendResponse($response);
    }

    private function sendResponse(\Core\Http\Response $response) {
        foreach ($response->getHeaders() as $key => $value) {
            header("$key: $value", false, $response->getStatusCode());
        }
        header($response->getStatus(), true, $response->getStatusCode());
        $this->sendSerializedContent($response->getContent(), $response->getContentType());
    }

    private function sendSerializedContent($content, $contentType) {
        $format = $this->getSerializationFormat($contentType);
        if ($format == null) {
            echo $content;
        } else {
            try {
                echo $this->serializer->serialize($content, $format);
            } catch (\Core\Serialization\SerializationException $e) {
                echo $e->getMessage();
            }
        }
    }

    private function getSerializationFormat(string $contentType) {
        switch ($contentType) {
            case 'application/json':
                return \Core\Serialization\Serializer::FORMAT_JSON;
            case 'application/xml':
                return \Core\Serialization\Serializer::FORMAT_XML;
            default:
                return null;
        }
    }

    private function bootstrap() {
        $this->initContainer();
        $this->initRouting();
        $this->serializer = $this->container->get(\Core\Serialization\Serializer::class);
    }

    /**
     * Dependency container initialization.
     * User can override this method to supply his own container
    */
    protected function initContainer() {
        $this->container = new \Core\Di\DependencyContainer();
        $this->container->registerSingleton(\Core\Web\Router::class);
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