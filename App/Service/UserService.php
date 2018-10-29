<?php

declare(strict_types=1);

namespace App\Service;


class UserService {

    /**
     * @var \Core\Database\AbstractRepository
     */
    private $repository;

    public function __construct(\App\Database\Repository\UserRepository $repository) {
        $this->repository = $repository;
    }

    public function get(int $id) {
        return $this->repository->get($id);
    }

    public function getAll(): array {
        return $this->repository->getAll();
    }

    /**
     * @param \App\Http\Model\UserRequest $request
     * @throws \Core\Database\DatabaseException
     */
    public function add(\App\Http\Model\UserRequest $request) {
        if ($this->repository->hasEmail($request->getEmail())) {
            throw new \Core\Database\DatabaseException('User with given email already exists');
        }
        $user = new \App\Database\Model\UserModel($request->getEmail(), $request->getFirstName(), $request->getLastName());
        $this->repository->save($user);
    }

    /**
     * @param int $id
     * @throws \Core\Database\DatabaseException
     */
    public function delete(int $id) {
        $this->repository->remove($id);
    }

    /**
     * @param int $id
     * @param \App\Http\Model\UserRequest $request
     * @throws \Core\Database\DatabaseException
     */
    public function update(int $id, \App\Http\Model\UserRequest $request) {
        /** @var \App\Database\Model\UserModel $entity */
        $entity = $this->repository->get($id);
        $entity->setFirstName($request->getFirstName());
        $entity->setLastName($request->getLastName());
        $this->repository->save($entity);
    }
}