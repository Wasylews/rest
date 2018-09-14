<?php

namespace Core\Di;


class DependencyContainer {

    /**
     * @field DependencyProvider[] $providers
    */
    private $providers = [];

    /**
     * Register new class in container
     * @param string $class
     */
    public function register(string $class) {
        $this->providers[$class] = new DependencyProvider($class);
    }

    /**
     * Register new singleton class in container
     * @param string $class
     */
    public function registerSingleton(string $class) {
        $this->providers[$class] = new SingletonDependencyProvider($class);
    }

    /**
     * Register new class provider
     * @param string $class class name to store in container
     * @param string $providerClass provider class name
     */
    public function registerProvider(string $class, string $providerClass) {
        $this->providers[$class] = new $providerClass($class);
    }

    /**
     * Get class instance from container
     * @param $class
     * @return mixed|null get instance or null if there is no provider for class
     */
    public function get(string $class) {
        if ($this->has($class)) {
            try {
                return $this->providers[$class]->get($this->resolveDependencies($class));
            } catch (DependencyException $e) {
                return null;
            }
        }
        return null;
    }

    public function has(string $class) {
        return array_key_exists($class, $this->providers);
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
                    if ($parameter->getType()->isBuiltin() && !$parameter->isDefaultValueAvailable()) {
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
        }
        return $parameters;
    }


}