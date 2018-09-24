<?php

declare(strict_types=1);

namespace App\Bootstrap;


class Application extends \Core\Bootstrap\AbstractApplication {

    protected function registerServices() {
        /**
         * User classes
         */
        $this->container->registerProvider(\Core\Serialization\Serializer::class,
            \App\Di\Provider\SerializerProvider::class);
        $this->container->registerSingleton(\App\Service\UserService::class);
        $this->container->registerSingleton(\App\Controller\UserController::class);
    }

    protected function initRoutes() {
        /**
         * Create new user
         */
        $this->router->post('/user', \App\Controller\UserController::class);

        /**
         * Get all users
         */
        $this->router->get('/user', \App\Controller\UserController::class);

        /**
         * Get user by id
         */
        $this->router->get('/user/{id}', \App\Controller\UserController::class);

        /**
         * Update user profile
         */
        $this->router->put('/user/{id}', \App\Controller\UserController::class);

        /**
         * Remove user from system
         */
        $this->router->delete('/user/{id}', \App\Controller\UserController::class);

    }
}