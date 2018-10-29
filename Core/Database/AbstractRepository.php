<?php

declare(strict_types=1);

namespace Core\Database;

abstract class AbstractRepository {

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $entityRepository;

    public function __construct(\Doctrine\ORM\EntityManager $entityManager, string $entityName) {
        $this->entityManager = $entityManager;
        $this->entityRepository = $entityManager->getRepository($entityName);
    }

    /**
     * @param AbstractModel $model
     * @throws DatabaseException
     */
    public function save(AbstractModel $model) {
        try {
            $this->entityManager->persist($model);
            $this->entityManager->flush($model);
        } catch (\Exception $e) {
            throw new DatabaseException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param int $id
     * @throws DatabaseException
     */
    public function remove(int $id) {
        $entity = $this->entityRepository->find($id);
        try {
            $this->entityManager->remove($entity);
        } catch (\Exception $e) {
            throw new DatabaseException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function get(int $id) {
        return $this->entityRepository->find($id);
    }

    public function getAll(): array {
        return $this->entityRepository->findAll();
    }
}