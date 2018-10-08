<?php

declare(strict_types=1);

namespace Core\Di;


class DependencyBinding {

    private $class;
    private $provider;
    private $singleton;

    public function __construct(string $class, $provider, bool $singleton = false) {
        $this->class = $class;
        $this->provider = $provider == null ? $class : $provider;
        $this->singleton = $singleton;
    }

    public function getClass(): string {
        return $this->class;
    }

    public function getProvider(): string {
        return $this->provider;
    }

    public function isSingleton(): bool {
        return $this->singleton;
    }


}