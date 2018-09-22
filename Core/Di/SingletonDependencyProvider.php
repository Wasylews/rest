<?php

declare(strict_types=1);

namespace Core\Di;


/**
 * Base class for singleton providers.
 * Stores class instance after first creation
*/
class SingletonDependencyProvider extends DependencyProvider {

    protected $instance;

    /**
     * @inheritdoc
    */
    public function get(array $dependencies) {
        if ($this->instance == null) {
            $this->instance = $this->makeInstance($dependencies);
        }
        return $this->instance;
    }
}