<?php

declare(strict_types=1);

namespace App\V1\Service;


class UserService {

    /**
     * @var \Core\Database\AbstractRepository
     */
    private $repository;

    public function __construct(\App\V1\Database\Repository\UserRepository $repository) {
        $this->repository = $repository;
    }

    public function get(int $id) {
        return $this->repository->get($id);
    }

    public function getAll(): array {
        return $this->repository->getAll();
    }

    /**
     * @param \App\V1\Http\Model\CreateUserRequest $request
     * @throws \Core\Database\DatabaseException
     */
    public function add(\App\V1\Http\Model\CreateUserRequest $request) {
        if ($this->repository->hasByEmail($request->getEmail())) {
            throw new \Core\Database\DatabaseException('User with given email already exists');
        }
        $user = new \App\V1\Database\Model\UserModel($request->getEmail(), $request->getFirstName(), $request->getLastName());
        $user->addTransaction(new \App\V1\Database\Model\TransactionModel(null, $user, $request->getBalance()));
        $this->repository->save($user);
    }

    /**
     * @param int $id
     * @throws \Core\Database\DatabaseException
     */
    public function delete(int $id) {
        /** @var \App\V1\Database\Model\UserModel $entity */
        $entity = $this->repository->get($id);
        if ($entity == null) {
            throw new \Core\Database\DatabaseException('User with given id doesn\'t exists');
        }
        $this->repository->remove($entity);
    }

    /**
     * @param int $id
     * @param \App\V1\Http\Model\UserRequest $request
     * @throws \Core\Database\DatabaseException
     */
    public function update(int $id, \App\V1\Http\Model\UserRequest $request) {
        /** @var \App\V1\Database\Model\UserModel $entity */
        $entity = $this->repository->get($id);
        if ($entity == null) {
            throw new \Core\Database\DatabaseException('User with given id doesn\'t exists');
        }
        if (!empty($request->getEmail())) {
            $entity->setEmail($request->getEmail());
        }
        if (!empty($request->getFirstName())) {
            $entity->setFirstName($request->getFirstName());
        }
        if (!empty($request->getLastName())) {
            $entity->setLastName($request->getLastName());
        }
        $this->repository->save($entity);
    }
}