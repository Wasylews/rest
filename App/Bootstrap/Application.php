<?php

declare(strict_types=1);

namespace App\Bootstrap;


class Application extends \Core\Bootstrap\AbstractApplication {

    protected function registerServices() {
        $this->container->bindSingleton(\Core\Serialization\Encoder\JsonEncoder::class);
        $this->container->bindSingleton(\Core\Serialization\Encoder\XmlEncoder::class);
        $this->container->bindSingleton(\Core\Serialization\Serializer::class,
            \App\Di\Provider\SerializerProvider::class);

        $this->container->bindSingleton(\Doctrine\ORM\EntityManager::class,
            \App\Di\Provider\DoctrineProvider::class);

        /**
         * Configs
        */
        $this->container->bindSingleton(\Core\Bootstrap\Config::class,
            \App\Di\Provider\ConfigProvider::class);

        /**
         * Services
        */
        $this->container->bindSingleton(\App\Service\UserService::class);
        $this->container->bindSingleton(\App\Service\TransactionService::class);

        /**
         * Controllers
        */
        $this->container->bindSingleton(\App\Controller\UserController::class);
        $this->container->bindSingleton(\App\Controller\TransactionController::class);
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