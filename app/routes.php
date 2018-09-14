<?php

/**
 * In this file we set url mappings for application.
 * For simplicity we are using regular expressions.
 *
 * Because of controller architecture it's better to use
 * different controllers for different REST resources.
 * Otherwise we need to handle different requests in a single handler.
*/

$router = $container->get(\core\web\Router::class);

// /user/{id}?page={page}
$router->get('\/user\/(?P<id>\d+)\?page=(?P<page>\d+)', \app\controller\AppController::class);