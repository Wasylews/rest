<?php

namespace Core\Utils;

/**
 * @internal Reflection utils for ioc container
*/
class ReflectionUtils {

    public static function newInstance(string $class) {
        try {
            $reflectionClass = new \ReflectionClass($class);
            return $reflectionClass->newInstanceWithoutConstructor();
        } catch (\ReflectionException $e) {
            return null;
        }
    }

    public static function newInstanceArgs(string $class, array $dependencies) {
        try {
            $reflectionClass = new \ReflectionClass($class);
            if ($reflectionClass->getConstructor() != null) {
                return $reflectionClass->newInstance(...$dependencies);
            }
            return $reflectionClass->newInstanceWithoutConstructor();
        } catch (\ReflectionException $e) {
            return null;
        }
    }
}