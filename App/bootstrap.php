<?php

require_once __DIR__.'/../vendor/autoload.php';

/**
 * Init dependencies
*/
$container = new \Core\Di\DependencyContainer();

$container->registerSingleton(\Core\Web\Router::class);
$container->register(\Core\Application::class);

$container->registerSingleton(\App\Service\UserService::class);
$container->registerSingleton(\App\Controller\UserController::class);

/**
 * Init routes
*/
require_once('routes.php');

return $container->get(\Core\Application::class);
