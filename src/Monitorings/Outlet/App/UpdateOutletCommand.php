<?php

declare(strict_types=1);

namespace Monitorings\Outlet\App;

use App\Exception\NotFoundException;
use Monitorings\Identity;
use Monitorings\Outlet\App\Dto\OutletDto;
use Monitorings\Outlet\Domain\Address;
use Monitorings\Outlet\Domain\CommercialNetworkRepository;
use Monitorings\Outlet\Domain\Outlet;
use Monitorings\Outlet\Domain\OutletRepository;

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
    public function execute(Identity $id, OutletDto $outletDto): Outlet
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
