<?php

declare(strict_types=1);

namespace Domain\Outlet\Domain;

use Domain\Common\CreatedAndUpdatedDatetime;

class Outlet
{
    use CreatedAndUpdatedDatetime;

    private OutletIdentity $id;

    private CommercialNetwork $commercialNetwork;

    private ?Address $address;

    public function __construct(
        CommercialNetwork $commercialNetwork,
        ?Address $address
    ) {
        $this->id = OutletIdentity::new();
        $this->commercialNetwork = $commercialNetwork;
        $this->address = $address;
    }

    public function getId(): OutletIdentity
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
