<?php

declare(strict_types=1);

namespace App\Di\Provider;


class DoctrineProvider implements \Core\Di\Provider\DependencyProviderInterface {

    /**
     * @var \Core\Bootstrap\Config $config
     */
    private $config;

    public function __construct(\Core\Bootstrap\Config $config) {
        $this->config = $config;
    }

    public function get() {
        $config = $this->getDatabaseConfiguration();
        try {
            return \Doctrine\ORM\EntityManager::create($this->config->get('database'), $config);
        } catch (\Doctrine\ORM\ORMException $e) {
            throw new \Core\Di\DependencyException($e);
        }
    }

    private function getDatabaseConfiguration(): \Doctrine\ORM\Configuration {
        if ($this->config->get('environment') == "dev") {
            $cache = new \Doctrine\Common\Cache\ArrayCache;
        } else {
            $cache = new \Doctrine\Common\Cache\ApcuCache;
        }

        $config = new \Doctrine\ORM\Configuration;
        $config->setMetadataCacheImpl($cache);
        $driverImpl = $config->newDefaultAnnotationDriver($config['database']['entity_folder']);
        $config->setMetadataDriverImpl($driverImpl);
        $config->setQueryCacheImpl($cache);
        $config->setProxyDir($config['database']['proxy_folder']);
        $config->setProxyNamespace($config['database']['proxy_namespace']);

        if ($this->config->get('environment') == "dev") {
            $config->setAutoGenerateProxyClasses(true);
        } else {
            $config->setAutoGenerateProxyClasses(false);
        }
        return $config;
    }
}