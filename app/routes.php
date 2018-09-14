<?php

$router = $container->get(\core\web\Router::class);

$router->get('/', \app\controller\AppController::class);