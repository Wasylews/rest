<?php

declare(strict_types=1);

namespace App\Bootstrap;


class Application extends \Core\Bootstrap\AbstractApplication {

    protected function registerServices() {
        $this->container->registerProvider(\Core\Serialization\Serializer::class,
            \App\Di\Provider\SerializerProvider::class);

        /**
         * Services
        */
        $this->container->registerSingleton(\App\Service\UserService::class);
        $this->container->registerSingleton(\App\Service\TransactionService::class);

        /**
         * Controllers
        */
        $this->container->registerSingleton(\App\Controller\UserController::class);
        $this->container->registerSingleton(\App\Controller\TransactionController::class);
    }

    protected function initRoutes() {
        $this->initUserRoutes();
        $this->initTransactionRoutes();
    }

    private function initUserRoutes() {
        /**
         * Create new user
         */
        $this->router->post('/user?format={type}',
            \App\Controller\UserController::class);

        /**
         * Get all users
         */
        $this->router->get('/user?format={type}',
            \App\Controller\UserController::class);

        /**
         * Get user by id
         */
        $this->router->get('/user/{id}?format={type}',
            \App\Controller\UserController::class);

        /**
         * Update user profile
         */
        $this->router->put('/user/{id}?format={type}',
            \App\Controller\UserController::class);

        /**
         * Remove user from system
         */
        $this->router->delete('/user/{id}',
            \App\Controller\UserController::class);

    }

    private function initTransactionRoutes() {
        /**
         * Create new transaction
         */
        $this->router->post('/transaction?format={type}',
            \App\Controller\TransactionController::class);

        /**
         * Get all transactions for user
         */
        $this->router->get('/transaction?user={userId}&format={type}',
            \App\Controller\TransactionController::class);

        /**
         * Get transaction by id
         */
        $this->router->get('/transaction/{id}?format={type}',
            \App\Controller\TransactionController::class);
    }
}