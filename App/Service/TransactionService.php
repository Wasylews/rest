<?php

declare(strict_types=1);

namespace App\Service;


class TransactionService {

    public function add(\App\Model\TransactionModel $transaction) {
    }

    public function get(int $transactionId): \App\Model\TransactionModel {
        return null;
    }

    public function getAllForUser(int $userId): array {
        return [];
    }
}