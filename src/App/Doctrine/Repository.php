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
        $this->assertFoundByAttribute(
            $entity = $this->findById($id),
            $id,
            'id'
        );

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
        $this->assertFoundByAttribute(
            $entity = $this->findByGuid($guid),
            $guid,
            'guid'
        );

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

    /**
     * @throws NotFoundException
     */
    protected function assertFoundByAttribute(?object $object, $value, ?string $attribute = null): void
    {
        if ($object === null) {
            throw new NotFoundException(sprintf('Entity of %s not found by value "%s" in field "%s"', $this->getClassName(), (string) $value, $attribute));
        }
    }
}
