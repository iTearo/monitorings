<?php

declare(strict_types=1);

namespace Domain\Outlet\App\Outlet;

use App\Exception\NotFoundException;
use Domain\Outlet\App\Dto\OutletDto;
use Domain\Outlet\Domain\Address;
use Domain\Outlet\Domain\CommercialNetworkRepository;
use Domain\Outlet\Domain\Outlet;
use Domain\Outlet\Domain\OutletRepository;
use Domain\Outlet\Domain\OutletIdentity;

class UpdateOutletCommand
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
    public function execute(OutletIdentity $id, OutletDto $outletDto): Outlet
    {
        $outlet = $this->outletRepository->getByIdOrFail($id);

        $outlet->setCommercialNetwork(
            $this->commercialNetworkRepository->getByIdOrFail($outletDto->commercialNetworkId)
        );

        $outlet->setAddress(
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
