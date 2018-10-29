<?php

namespace App\Database\Repository;


class TransactionRepository extends \Core\Database\AbstractRepository {

    public function __construct(\Doctrine\ORM\EntityManager $entityManager) {
        parent::__construct($entityManager, \App\Database\Model\TransactionModel::class);
    }
}