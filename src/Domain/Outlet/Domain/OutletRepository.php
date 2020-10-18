<?php

declare(strict_types=1);

namespace Domain\Outlet\Domain;

use App\Exception\NotFoundException;
use Domain\Pagination\Pagination;

interface OutletRepository
{
    public function save(object $outlet): void;

    public function getById(OutletIdentity $identity): ?Outlet;

    /**
     * @throws NotFoundException
     */
    public function getByIdOrFail(OutletIdentity $identity): Outlet;

    public function getAllPaginated(int $pageNumber, int $pageSize = 10): Pagination;
}
