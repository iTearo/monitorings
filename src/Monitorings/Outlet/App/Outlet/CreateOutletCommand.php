<?php

declare(strict_types=1);

namespace Monitorings\Outlet\App\Outlet;

use App\Exception\NotFoundException;
use Monitorings\Outlet\App\Dto\OutletDto;
use Monitorings\Outlet\Domain\Address;
use Monitorings\Outlet\Domain\CommercialNetworkRepository;
use Monitorings\Outlet\Domain\Outlet;
use Monitorings\Outlet\Domain\OutletRepository;

class CreateOutletCommand
{
    private OutletRepository $outletRepository;

    private CommercialNetworkRepository $commercialNetworkRepository;

    public function __construct(
        OutletRepository $outletRepository,
        CommercialNetworkRepository $commercialNetworkRepository
    ) {
        $this->outletRepository = $outletRepository;
        $this->commercialNetworkRepository = $commercialNetworkRepository;
    }

    /**
     * @throws NotFoundException
     */
    public function execute(OutletDto $outletDto): Outlet
    {
        $outlet = new Outlet(
            $this->commercialNetworkRepository->getByIdOrFail($outletDto->commercialNetworkId),
            new Address(
                $outletDto->address->building,
                $outletDto->address->street,
                $outletDto->address->locality
            )
        );

        $this->outletRepository->save($outlet);

        return $outlet;
    }
}
