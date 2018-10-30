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

    /**
     * @param \App\Http\Model\CreateTransactionRequest $request
     * @throws \Exception
     */
    public function add(\App\Http\Model\CreateTransactionRequest $request) {
        $userFrom = $this->userRepository->get($request->getFrom());
        if ($userFrom == null) {
            throw new \Exception(sprintf('Cannot find user by given id %d', $request->getFrom()));
        }
        $userTo = $this->userRepository->get($request->getTo());
        if ($userTo == null) {
            throw new \Exception(sprintf('Cannot find user by given id %d', $request->getTo()));
        }

        $transaction = new \App\Database\Model\TransactionModel($userFrom, $userTo, $request->getAmount());
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