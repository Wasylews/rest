<?php

namespace Di\Provider;


class ConfigProvider implements \Core\Di\Provider\DependencyProviderInterface {

    /**
     * @return \Core\Bootstrap\Config
     */
    public function get() {
        $json = file_get_contents('config.json');
        return new \Core\Bootstrap\Config(json_decode($json, true));
    }
}