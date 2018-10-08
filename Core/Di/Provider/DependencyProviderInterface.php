<?php

declare(strict_types=1);

namespace Core\Di\Provider;

/**
 * Interface for class factories
*/
interface DependencyProviderInterface {

    /**
     * @return mixed
     * @throws \Core\Di\DependencyException
     */
    public function get();
}