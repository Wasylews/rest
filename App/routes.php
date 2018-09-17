<?php

/**
 * In this file we set url mappings for application.
 * Mapping examples:
 * /user/{id}
 * /user/{id}/{page}
 * /user/?id={id}
 * /user/?id={id}&page={page}
 * /user/{id}?page={page}
 *
 * Due Controller's architecture it's better to use
 * different controllers for different REST resources.
 * Otherwise we need to handle different requests in a single handler.
*/

/** @var \Core\Web\Router $router */
$router = $container->get(\Core\Web\Router::class);
$router->setContainer($container);

/**
 * Create new user
*/
$router->post('/user', \App\Controller\UserController::class);

/**
 * Get all users
 */
$router->get('/user', \App\Controller\UserController::class);

/**
 * Get user by id
 */
$router->get('/user/{id}', \App\Controller\UserController::class);

/**
 * Update user profile
*/
$router->put('/user/{id}', \App\Controller\UserController::class);

/**
 * Remove user from system
*/
$router->delete('/user/{id}', \App\Controller\UserController::class);
