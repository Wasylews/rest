<?php

declare(strict_types=1);

namespace App\Di\Provider;


use Core\Serialization\SerializationException;

class SerializerProvider extends \Core\Di\SingletonDependencyProvider {

    /**
     * Get serializer configured with encoders
     * @param array $dependencies
     * @return \Core\Serialization\Serializer
     */
    public function get(array $dependencies) {
        /** @var \Core\Serialization\Serializer $serializer */
        $serializer = parent::get($dependencies);
        try {
            $serializer->addEncoder(\Core\Serialization\Serializer::FORMAT_JSON,
                new \Core\Serialization\Encoder\JsonEncoder());
        } catch (SerializationException $e) {
            return null;
        }
        return $serializer;
    }
}