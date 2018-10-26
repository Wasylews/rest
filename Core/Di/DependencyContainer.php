<?php

declare(strict_types=1);

namespace Core\Di;

class DependencyContainer {

    /**
     * @var DependencyBinding[]
    */
    private $bindings = [];

    /**
     * @var array cache for singleton instances
    */
    private $instanceCache = [];

    /**
     * Register provider for some class
     * If there is no provider, then class provides itself
     * @param string $class
     * @param string|null $provider
     */
    public function bind(string $class, string $provider = null) {
        $this->bindings[$class] = new DependencyBinding($class, $provider);
    }

    /**
     * Register provider with singleton lifetime scope
     * @param string $class
     * @param string|null $provider
     */
    public function bindSingleton(string $class, string $provider = null) {
        $this->bindings[$class] = new DependencyBinding($class, $provider, true);
    }

    /**
     * Get class instance from container
     * @param $class
     * @return mixed|null
     */
    public function get(string $class) {
        try {
            if ($this->has($class)) {
                $binding = $this->bindings[$class];
                if ($binding->isSingleton()) {
                    return $this->getSingleton($binding);
                }
                return $this->getInstance($binding);
            }
        } catch (DependencyException $ex) {
            return null;
        }
        return null;
    }

    /**
     * Check if container has binding for $class
     * @param string $class
     * @return bool
     */
    public function has(string $class) {
        return array_key_exists($class, $this->bindings);
    }

    /**
     * @param DependencyBinding $binding
     * @return mixed
     * @throws DependencyException
     */
    private function getSingleton(DependencyBinding $binding) {
        if (!$this->hasCachedInstance($binding->getClass())) {
            $this->instanceCache[$binding->getClass()] = $this->getInstance($binding);
        }
        return $this->instanceCache[$binding->getClass()];
    }

    private function hasCachedInstance(string $class) {
        return array_key_exists($class, $this->instanceCache);
    }

    /**
     * @param DependencyBinding $binding
     * @return mixed|null|object
     * @throws DependencyException
     */
    private function getInstance(DependencyBinding $binding) {
        $provider = $this->getProvider($binding->getProvider());
        if ($provider instanceof Provider\DependencyProviderInterface) {
            try {
                return $provider->get();
            } catch (DependencyException $e) {
                return null;
            }
        }
        return $provider;
    }

    /**
     * @param string $class
     * @return null|object
     * @throws DependencyException
     */
    private function getProvider(string $class) {
        return \Core\Utils\ReflectionUtils::newInstanceArgs($class, $this->resolveDependencies($class));
    }

    /**
     * Collect all dependencies for constructor of class
     * @param $class
     * @return array
     * @throws DependencyException if it can't find provider for parameter in this container
     */
    private function resolveDependencies(string $class): array {
        $dependencies = [];
        $parameters = $this->getConstructorParameters($class);
        foreach ($parameters as $parameter) {
            if (!$this->has($parameter)) {
                throw new DependencyException(sprintf('No provider available for %s', $parameter));
            } else {
                array_push($dependencies, $this->get($parameter));
            }
        }
        return $dependencies;
    }

    /**
     * Collect types list of constructor parameters
     * @param $class
     * @return array
     * @throws DependencyException if parameter resolving failed
     */
    private function getConstructorParameters(string $class): array {
        $parameters = [];
        try {
            $reflectionClass = new \ReflectionClass($class);
            $constructor = $reflectionClass->getConstructor();
            if ($constructor != null) {
                foreach ($constructor->getParameters() as $parameter) {
                    if ($parameter->getType()->isBuiltin()) {
                        if ($parameter->isDefaultValueAvailable()) {
                            continue;
                        }
                        throw new DependencyException(sprintf('No default value available for %s in %s::%s()',
                            $parameter->getName(),
                            $parameter->getDeclaringClass()->getName(),
                            $parameter->getDeclaringFunction()->getName()
                        ));
                    } else {
                        array_push($parameters, $parameter->getClass()->getName());
                    }
                }
            }
        } catch (\ReflectionException $e) {
            throw new DependencyException($e->getMessage(), $e->getCode(), $e);
        }
        return $parameters;
    }
}