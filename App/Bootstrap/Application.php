<?php

declare(strict_types=1);

namespace App\Bootstrap;


class Application extends \Core\Bootstrap\AbstractApplication {

    protected function bindServices() {
        $this->container->bindSingleton(\Core\Serialization\Encoder\JsonEncoder::class);
        $this->container->bindSingleton(\Core\Serialization\Encoder\XmlEncoder::class);
        $this->container->bindSingleton(\Core\Serialization\Serializer::class,
            \App\Di\Provider\SerializerProvider::class);

        /**
         * Database
        */
        $this->container->bindSingleton(\Doctrine\ORM\EntityManager::class,
            \App\Di\Provider\DoctrineProvider::class);

        /**
         * Configs
        */
        $this->container->bindSingleton(\Core\Utils\PathResolver::class,
            \App\Di\Provider\PathResolverProvider::class);
        $this->container->bindSingleton(\Core\Bootstrap\Config::class,
            \App\Di\Provider\ConfigProvider::class);
    }

    protected function loadBundles() {
        $this->addBundle(new \App\V1\V1Bundle());
    }
}