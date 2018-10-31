<?php

namespace App\V1;


class V1Bundle implements \Core\Bootstrap\BundleInterface {

    function bindServices(\Core\Di\DependencyContainer $container) {
        /**
         * Repositories
         */
        $container->bindSingleton(Database\Repository\UserRepository::class);
        $container->bindSingleton(Database\Repository\TransactionRepository::class);

        /**
         * Services
         */
        $container->bindSingleton(Service\UserService::class);
        $container->bindSingleton(Service\TransactionService::class);

        /**
         * Controllers
         */
        $container->bindSingleton(Http\Controller\UserController::class);
        $container->bindSingleton(Http\Controller\TransactionController::class);
    }

    function initRoutes(\Core\Web\Router $router) {
        $this->initUserRoutes($router);
        $this->initTransactionRoutes($router);
    }

    private function initUserRoutes(\Core\Web\Router $router) {
        /**
         * Create new user
         */
        $router->post('/v1/user?format={type}',
            Http\Controller\UserController::class);

        /**
         * Get all users
         */
        $router->get('/v1/user?format={type}',
            Http\Controller\UserController::class);

        /**
         * Get user by id
         */
        $router->get('/v1/user/{id}?format={type}',
            Http\Controller\UserController::class);

        /**
         * Update user profile
         */
        $router->put('/v1/user/{id}?format={type}',
            Http\Controller\UserController::class);

        /**
         * Remove user from system
         */
        $router->delete('/v1/user/{id}?format={type}',
            Http\Controller\UserController::class);

    }

    private function initTransactionRoutes(\Core\Web\Router $router) {
        /**
         * Create new transaction
         */
        $router->post('/v1/transaction?format={type}',
            Http\Controller\TransactionController::class);

        /**
         * Get all transactions for user
         */
        $router->get('/v1/transaction?user={userId}&format={type}',
            Http\Controller\TransactionController::class);

        /**
         * Get transaction by id
         */
        $router->get('/v1/transaction/{id}?format={type}',
            Http\Controller\TransactionController::class);
    }
}