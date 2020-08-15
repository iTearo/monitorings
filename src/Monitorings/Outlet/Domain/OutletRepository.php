<?php

declare(strict_types=1);

namespace Monitorings\Outlet\Domain;

use App\Exception\NotFoundException;
use Monitorings\Identity;
use Monitorings\Pagination\Pagination;

interface OutletRepository
{
    public function save(object $outlet): void;

    public function getById(Identity $identity): ?Outlet;

    /**
     * @throws NotFoundException
     */
    public function getByIdOrFail(Identity $identity): Outlet;

    public function getAllPaginated(int $pageNumber, int $pageSize = 10): Pagination;
}
