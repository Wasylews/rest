<?php

declare(strict_types=1);

namespace App\Service;


class UserService {

    public function get(int $id): \App\Model\UserModel {
        $user = new \App\Model\UserModel();
        $user->setId($id);
        $user->setFirstName('John');
        $user->setLastName('Snow');
        return $user;
    }

    public function getAll(): array {
        return null;
    }

    public function add($user) {

    }
}