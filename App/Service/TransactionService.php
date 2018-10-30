<?php

declare(strict_types=1);

namespace App\Service;


class TransactionService {

    /**
     * @var \App\Database\Repository\TransactionRepository
     */
    private $transactionRepository;

    /**
     * @var \Core\Database\AbstractRepository
     */
    private $userRepository;

    public function __construct(\App\Database\Repository\TransactionRepository $transactionRepository,
                                \App\Database\Repository\UserRepository $userRepository) {
        $this->userRepository = $userRepository;
        $this->transactionRepository = $transactionRepository;
    }

    public function add(\App\Database\Model\TransactionModel $transaction) {
        $this->transactionRepository->save($transaction);
    }

    /**
     * @param int $transactionId
     * @return \App\Database\Model\TransactionModel
     * @throws \Exception
     */
    public function get(int $transactionId): \App\Database\Model\TransactionModel {
        /** @var \App\Database\Model\TransactionModel $transaction */
        $transaction = $this->transactionRepository->get($transactionId);
        if ($transaction == null) {
            throw new \Exception('Cannot find transaction by given id');
        }
        return $transaction;
    }

    /**
     * @param int $userId
     * @return \Doctrine\Common\Collections\Collection
     * @throws \Exception
     */
    public function getAllForUser(int $userId): \Doctrine\Common\Collections\Collection {
        /** @var \App\Database\Model\UserModel|null $user */
        $user = $this->userRepository->get($userId);
        if ($user != null) {
            return $user->getTransactions();
        }
        throw new \Exception('Cannot find user by given id');
    }
}