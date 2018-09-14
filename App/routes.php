<?php

/**
 * In this file we set url mappings for application.
 * For simplicity we are using regular expressions.
 *
 * Because of Controller architecture it's better to use
 * different controllers for different REST resources.
 * Otherwise we need to handle different requests in a single handler.
*/

$router = $container->get(\Core\Web\Router::class);

// /user/{id}?page={page}
$router->get('\/user\/(?P<id>\d+)\?page=(?P<page>\d+)', \App\Controller\AppController::class);