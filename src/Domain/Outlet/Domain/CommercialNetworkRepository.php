<?php

declare(strict_types=1);

namespace Domain\Outlet\Domain;

use App\Exception\NotFoundException;
use Domain\Pagination\Pagination;

interface CommercialNetworkRepository
{
    public function save(object $commercialNetwork): void;

    public function getById(CommercialNetworkIdentity $identity): ?CommercialNetwork;

    /**
     * @throws NotFoundException
     */
    public function getByIdOrFail(CommercialNetworkIdentity $identity): CommercialNetwork;

    /**
     * @return CommercialNetwork[]
     */
    public function getAll(): array;

    public function getAllPaginated(int $pageNumber, int $pageSize = 10): Pagination;
}
