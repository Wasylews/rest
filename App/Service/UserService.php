<?php

declare(strict_types=1);

namespace App\Service;


class UserService {

    public function get(int $id): \App\Model\UserModel {
        return new \App\Model\UserModel($id, 'John', 'Snow');
    }

    public function getAll(): array {
        return null;
    }

    public function add($user) {

    }
}