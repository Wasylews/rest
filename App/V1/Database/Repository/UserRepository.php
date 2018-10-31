<?php

namespace App\V1\Database\Repository;


class UserRepository extends \Core\Database\AbstractRepository {

    public function __construct(\Doctrine\ORM\EntityManager $entityManager) {
        parent::__construct($entityManager, \App\V1\Database\Model\UserModel::class);
    }

    public function hasByEmail(string $email): bool {
        return $this->entityRepository->findOneBy(['email' => $email]) != null;
    }
}