<?php

declare(strict_types=1);

namespace Domain\Outlet\Data;

use App\Doctrine\Repository;
use App\Exception\NotFoundException;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Domain\Outlet\Domain\Outlet;
use Domain\Outlet\Domain\OutletRepository;
use Domain\Outlet\Domain\OutletIdentity;
use Domain\Pagination\Pagination;

class DoctrineOutletRepository extends Repository implements OutletRepository
{
    public const TABLE = 'outlet';

    public function getById(OutletIdentity $identity): ?Outlet
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->findByGuid($identity->toString());
    }

    /**
     * @throws NotFoundException
     */
    public function getByIdOrFail(OutletIdentity $identity): Outlet
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->findByGuidOrFail($identity->toString());
    }

    public function getAllPaginated(int $pageNumber, int $pageSize = 10): Pagination
    {
        if ($pageSize === null || $pageSize < 1 || $pageSize > 10) {
            $pageSize = 10;
        }

        $query = $this
            ->createQueryBuilder('outlet')
            ->orderBy('outlet.createdAt', 'ASC')
            ->setFirstResult(($pageNumber - 1) * $pageSize)
            ->setMaxResults($pageSize)
            ->getQuery()
        ;

        $paginator = new Paginator($query);

        $totalRowsCount = $paginator->count() % $pageSize === 0
            ? $paginator->count() / $pageSize
            : (int) ($paginator->count() / $pageSize) + 1;

        return new Pagination(
            $paginator->getQuery()->getResult(),
            $pageNumber,
            $totalRowsCount,
        );
    }
}
