<?php

declare(strict_types=1);

namespace Monitorings\Outlet\App\CommercialNetwork;

use App\Exception\NotFoundException;
use Monitorings\Outlet\App\Dto\CommercialNetworkDto;
use Monitorings\Outlet\Domain\CommercialNetwork;
use Monitorings\Outlet\Domain\CommercialNetworkRepository;

class CreateCommercialNetworkCommand
{
    private CommercialNetworkRepository $commercialNetworkRepository;

    public function __construct(
        CommercialNetworkRepository $commercialNetworkRepository
    ) {
        $this->commercialNetworkRepository = $commercialNetworkRepository;
    }

    /**
     * @throws NotFoundException
     */
    public function execute(CommercialNetworkDto $commercialNetworkDto): CommercialNetwork
    {
        $commercialNetwork = new CommercialNetwork(
            $commercialNetworkDto->title
        );

        $this->commercialNetworkRepository->save($commercialNetwork);

        return $commercialNetwork;
    }
}
