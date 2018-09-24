<?php

declare(strict_types=1);

namespace App\Service;


class UserService {

    public function get(int $id): \App\Model\UserModel {
        return new \App\Model\UserModel($id, 'John', 'Snow');
    }

    public function getAll(): array {
        return [];
    }

    public function add(\App\Model\UserModel $user) {
    }

    public function delete(int $userId) {
    }

    public function update(int $userId, \App\Model\UserModel $newUser) {
    }
}