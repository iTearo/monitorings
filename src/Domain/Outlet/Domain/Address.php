<?php

declare(strict_types=1);

namespace Domain\Outlet\Domain;

class Address
{
    private string $locality;

    private string $street;

    private string $building;

    public function __construct(
        string $building,
        string $street,
        string $city
    ) {
        $this->building = $building;
        $this->street = $street;
        $this->locality = $city;
    }

    public function getLocality(): string
    {
        return $this->locality;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getBuilding(): string
    {
        return $this->building;
    }

    public function __toString(): string
    {
        return sprintf(
            '%s, %s, %s',
            $this->locality,
            $this->street,
            $this->building,
        );
    }
}
