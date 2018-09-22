<?php

declare(strict_types=1);

namespace Core;


use Core\Serialization\Serializer;

class Application {

    /**
     * @var Web\Router
     */
    private $router;

    /**
     * @var Serialization\Serializer
     */
    private $serializer;

    public function __construct(Web\Router $router, Serialization\Serializer $serializer) {
        $this->router = $router;
        $this->serializer = $serializer;
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
        $this->sendSerializedContent($response->getContent(), $response->getContentType());
    }

    private function sendSerializedContent($content, $contentType) {
        $format = $this->getSerializationFormat($contentType);
        if ($format == null) {
            echo $content;
        } else {
            try {
                echo $this->serializer->serialize($content, $format);
            } catch (Serialization\SerializationException $e) {
                echo $e->getMessage();
            }
        }
    }

    private function getSerializationFormat(string $contentType) {
        switch ($contentType) {
            case 'application/json':
                return Serializer::FORMAT_JSON;
            case 'application/xml':
                return Serializer::FORMAT_XML;
            default:
                return null;
        }
    }
}