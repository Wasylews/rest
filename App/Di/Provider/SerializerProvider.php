<?php

declare(strict_types=1);

namespace App\Di\Provider;


class SerializerProvider extends \Core\Di\SingletonDependencyProvider {

    /**
     * Get serializer configured with encoders
     * @param array $dependencies
     * @return \Core\Serialization\Serializer
     */
    protected function makeInstance(array $dependencies) {
        /** @var \Core\Serialization\Serializer $serializer */
        $serializer = parent::makeInstance($dependencies);
        try {
            $serializer->addEncoder(\Core\Serialization\Serializer::FORMAT_JSON,
                new \Core\Serialization\Encoder\JsonEncoder());

            $serializer->addEncoder(\Core\Serialization\Serializer::FORMAT_XML,
                new \Core\Serialization\Encoder\XmlEncoder());
        } catch (\Core\Serialization\SerializationException $e) {
            return null;
        }
        return $serializer;
    }
}