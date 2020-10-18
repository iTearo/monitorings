<?php

declare(strict_types=1);

namespace Domain\Outlet\Domain;

use App\Exception\NotFoundException;
use Domain\Common\Identity;
use Domain\Pagination\Pagination;

interface CommercialNetworkRepository
{
    public function save(object $commercialNetwork): void;

    public function getById(Identity $identity): ?CommercialNetwork;

    /**
     * @throws NotFoundException
     */
    public function getByIdOrFail(Identity $identity): CommercialNetwork;

    /**
     * @return CommercialNetwork[]
     */
    public function getAll(): array;

    public function getAllPaginated(int $pageNumber, int $pageSize = 10): Pagination;
}
