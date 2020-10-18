<?php

declare(strict_types=1);

namespace Domain\Outlet\Data;

use App\Doctrine\Repository;
use App\Exception\NotFoundException;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Domain\Common\Identity;
use Domain\Outlet\Domain\CommercialNetwork;
use Domain\Outlet\Domain\CommercialNetworkRepository;
use Domain\Pagination\Pagination;

class DoctrineCommercialNetworkRepository extends Repository implements CommercialNetworkRepository
{
    public const TABLE = 'commercial_network';

    public function getById(Identity $identity): ?CommercialNetwork
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->findByGuid($identity->toString());
    }

    /**
     * @throws NotFoundException
     */
    public function getByIdOrFail(Identity $identity): CommercialNetwork
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->findByGuidOrFail($identity->toString());
    }

    public function getAll(): array
    {
        return $this->findAll();
    }

    public function getAllPaginated(int $pageNumber, int $pageSize = 10): Pagination
    {
        if ($pageSize === null || $pageSize < 1 || $pageSize > 10) {
            $pageSize = 10;
        }

        $query = $this
            ->createQueryBuilder('commercial_network')
            ->orderBy('commercial_network.createdAt', 'ASC')
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
