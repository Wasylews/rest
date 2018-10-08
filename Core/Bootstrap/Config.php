<?php

namespace Core\Bootstrap;


class Config {

    private $config;

    public function __construct(array $config = []) {
        $this->config = $config;
    }

    public function get(string $key, $default = null) {
        if (array_key_exists($key, $this->config)) {
            return $this->config[$key];
        }
        return $default;
    }
}