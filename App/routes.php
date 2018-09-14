<?php

/**
 * In this file we set url mappings for application.
 * Mapping examples:
 * /user/{id}
 * /user/{id}/{page}
 * /user?id={id}
 * /user?id={id}&page={page}
 * /user/{id}?page={page}
 *
 * Because of Controller architecture it's better to use
 * different controllers for different REST resources.
 * Otherwise we need to handle different requests in a single handler.
*/

$router = $container->get(\Core\Web\Router::class);

$router->get('/user/{id}?page={page}', \App\Controller\AppController::class);
$router->get('/user?id={id}&page={page}', \App\Controller\AppController::class);