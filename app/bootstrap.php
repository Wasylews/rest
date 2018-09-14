<?php

require_once __DIR__.'/../vendor/autoload.php';

/**
 * Init dependencies
*/
$container = new \core\di\DependencyContainer();

$container->register(\core\web\Router::class);
$container->register(\core\Application::class);

/**
 * Init routes
*/
require_once('routes.php');


return $container->get(\core\Application::class);