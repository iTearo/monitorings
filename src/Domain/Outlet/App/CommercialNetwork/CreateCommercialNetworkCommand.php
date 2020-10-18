<?php

declare(strict_types=1);

namespace Domain\Outlet\App\CommercialNetwork;

use App\Exception\NotFoundException;
use Domain\Outlet\App\Dto\CommercialNetworkDto;
use Domain\Outlet\Domain\CommercialNetwork;
use Domain\Outlet\Domain\CommercialNetworkRepository;

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
