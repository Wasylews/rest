<?php

namespace App\V1\Database\Repository;


class TransactionRepository extends \Core\Database\AbstractRepository {

    public function __construct(\Doctrine\ORM\EntityManager $entityManager) {
        parent::__construct($entityManager, \App\V1\Database\Model\TransactionModel::class);
    }
}