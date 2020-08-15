<?php

declare(strict_types=1);

namespace App\Doctrine;

use App\Exception\NotFoundException;
use Doctrine\ORM\EntityRepository;

class Repository extends EntityRepository
{
    public function findById(int $id): ?object
    {
        return $this->find($id);
    }

    /**
     * @throws NotFoundException
     */
    public function findByIdOrFail(int $id): object
    {
        $entity = $this->findById($id);

        if ($entity === null) {
            throw new NotFoundException(sprintf('Entity of %s with id %s not found', $this->getClassName(), $id));
        }

        return $entity;
    }

    /**
     * @throws NotFoundException
     */
    public function findByIdOrFailAllowNull(int $id): ?object
    {
        if ($id === null) {
            return null;
        }

        return $this->findByIdOrFail($id);
    }

    public function findByGuid(string $guid): ?object
    {
        return $this->find($guid);
    }

    /**
     * @throws NotFoundException
     */
    public function findByGuidOrFail(string $guid): object
    {
        $entity = $this->findByGuid($guid);

        if ($entity === null) {
            throw new NotFoundException(sprintf('Entity of %s with guid %s not found', $this->getClassName(), $guid));
        }

        return $entity;
    }

    /**
     * @throws NotFoundException
     */
    public function findByGuidOrFailAllowNull(string $guid): ?object
    {
        if ($guid === null) {
            return null;
        }

        return $this->findByGuidOrFail($guid);
    }

    public function save(object $entity): void
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $this->_em->persist($entity);

        /** @noinspection PhpUnhandledExceptionInspection */
        $this->_em->flush($entity);
    }

    public function delete(object $entity): void
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $this->_em->remove($entity);

        /** @noinspection PhpUnhandledExceptionInspection */
        $this->_em->flush($entity);
    }
}
