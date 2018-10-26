<?php

declare(strict_types=1);

namespace App\Di\Provider;


class ConfigProvider implements \Core\Di\Provider\DependencyProviderInterface {

    /**
     * @var \Core\Utils\PathResolver
     */
    private $pathResolver;

    public function __construct(\Core\Utils\PathResolver $pathResolver) {
        $this->pathResolver = $pathResolver;
    }

    /**
     * @return \Core\Bootstrap\Config
     */
    public function get() {
        $json = file_get_contents($this->pathResolver->resolveConfigPath('config.json'));
        return new \Core\Bootstrap\Config(json_decode($json, true));
    }
}