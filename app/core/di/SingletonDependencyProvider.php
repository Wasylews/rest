<?php

namespace core\di;


/**
 * Base class for singleton providers
 * Stores class instance after first creation
*/
class SingletonDependencyProvider extends DependencyProvider {

    protected $instance;

    /**
     * @inheritdoc
    */
    public function get(array $dependencies) {
        if ($this->instance == null) {
            $this->instance = parent::get($dependencies);
        }
        return $this->instance;
    }
}