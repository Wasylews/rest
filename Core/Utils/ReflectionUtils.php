<?php

namespace Core\Utils;

/**
 * @internal Reflection utils for ioc container
*/
class ReflectionUtils {

    /**
     * Check if given class name is name of an interface
     * @param string $class
     * @return bool
     */
    public static function isInterface(string $class): bool {
        try {
            $reflectionClass = new \ReflectionClass($class);
            return $reflectionClass->isInterface();
        } catch (\ReflectionException $e) {
            return false;
        }
    }

    public static function implementsInterface(string $class, string $interface): bool {
        if (self::isInterface($interface)) {
            $interfaces = class_implements($class);
            return in_array($interface, $interfaces);
        }
        return false;
    }

    public static function newInstance(string $class) {
        try {
            $reflectionClass = new \ReflectionClass($class);
            return $reflectionClass->newInstanceWithoutConstructor();
        } catch (\ReflectionException $e) {
            return null;
        }
    }
}