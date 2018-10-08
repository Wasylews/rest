<?php

declare(strict_types=1);

namespace App\Di\Provider;


class SerializerProvider implements \Core\Di\Provider\DependencyProviderInterface {

    /**
     * @var \Core\Serialization\Encoder\XmlEncoder
     */
    private $xmlEncoder;
    /**
     * @var \Core\Serialization\Encoder\JsonEncoder
     */
    private $jsonEncoder;

    public function __construct(\Core\Serialization\Encoder\XmlEncoder $xmlEncoder,
                                \Core\Serialization\Encoder\JsonEncoder $jsonEncoder) {
        $this->xmlEncoder = $xmlEncoder;
        $this->jsonEncoder = $jsonEncoder;
    }

    public function get() {
        $serializer = new \Core\Serialization\Serializer();
        try {
            $serializer->addEncoder(\Core\Serialization\Serializer::FORMAT_JSON, $this->jsonEncoder);
            $serializer->addEncoder(\Core\Serialization\Serializer::FORMAT_XML, $this->xmlEncoder);
        } catch (\Core\Serialization\SerializationException $e) {
            throw new \Core\Di\DependencyException($e);
        }
        return $serializer;
    }
}