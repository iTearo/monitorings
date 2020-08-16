<?php

declare(strict_types=1);

namespace Monitorings\Outlet\Domain;

use Monitorings\CreatedAndUpdatedDatetime;
use Monitorings\Identity;

class Outlet
{
    use CreatedAndUpdatedDatetime;

    private Identity $id;

    private CommercialNetwork $commercialNetwork;

    private ?Address $address;

    public function __construct(
        CommercialNetwork $commercialNetwork,
        ?Address $address
    ) {
        $this->id = Identity::new();
        $this->commercialNetwork = $commercialNetwork;
        $this->address = $address;
    }

    public function getId(): Identity
    {
        return $this->id;
    }

    public function getCommercialNetwork(): CommercialNetwork
    {
        return $this->commercialNetwork;
    }

    public function setCommercialNetwork(CommercialNetwork $commercialNetwork): void
    {
        $this->commercialNetwork = $commercialNetwork;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function setAddress(Address $address): void
    {
        $this->address = $address;
    }
}
