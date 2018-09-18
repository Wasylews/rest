<?php

require_once __DIR__.'/../vendor/autoload.php';

/**
 * Init dependencies
*/
$container = new \Core\Di\DependencyContainer();

/**
 * Serialization
*/
$container->registerSingleton(\Core\Serialization\Encoder\JsonEncoder::class);
$container->registerProvider(\Core\Serialization\Serializer::class,
    \App\Di\Provider\SerializerProvider::class);

$container->registerSingleton(\Core\Web\Router::class);
$container->register(\Core\Application::class);

/**
 * User classes
*/
$container->registerSingleton(\App\Service\UserService::class);
$container->registerSingleton(\App\Controller\UserController::class);

/**
 * Init routes
*/
require_once('routes.php');

return $container->get(\Core\Application::class);
