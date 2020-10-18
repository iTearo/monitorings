<?php

declare(strict_types=1);

namespace Domain\Outlet\App\Outlet;

use App\Exception\NotFoundException;
use Domain\Outlet\Domain\CommercialNetworkIdentity;
use Domain\Outlet\OutletAppEnv;
use Domain\Outlet\OutletEnv;
use Domain\Outlet\Domain\OutletIdentity;
use TestTools\DbTestCase;

class UpdateOutletCommandTest extends DbTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        self::deleteAllFromTables(
            OutletAppEnv::getUsedTables(),
        );
    }

    public function test_execute(): void
    {
        // Arrange
        $outlet = OutletAppEnv::createOutlet();

        $commercialNetwork = OutletAppEnv::createCommercialNetwork();

        $outletDto = OutletEnv::createOutletDto();
        $outletDto->commercialNetworkId = $commercialNetwork->getId();

        $updateOutletCommand = self::makeUpdateOutletCommand();

        // Act
        $outlet = $updateOutletCommand->execute($outlet->getId(), $outletDto);

        // Assert
        self::assertEquals($outlet->getCommercialNetwork()->getId(), $commercialNetwork->getId());
        self::assertEquals($outlet->getAddress()->getBuilding(), $outletDto->address->building);
        self::assertEquals($outlet->getAddress()->getStreet(), $outletDto->address->street);
        self::assertEquals($outlet->getAddress()->getLocality(), $outletDto->address->locality);
    }

    public function test_execute_outletNotFound(): void
    {
        // Arrange
        $outletIdentity = OutletIdentity::new();

        $outletDto = OutletEnv::createOutletDto();
        $outletDto->commercialNetworkId = CommercialNetworkIdentity::new();

        $updateOutletCommand = self::makeUpdateOutletCommand();

        // Assert
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessageMatches('/.*Outlet.*/');

        // Act
        $updateOutletCommand->execute($outletIdentity, $outletDto);
    }

    public function test_execute_commercialNetworkNotFound(): void
    {
        // Arrange
        $outlet = OutletAppEnv::createOutlet();

        $outletDto = OutletEnv::createOutletDto();
        $outletDto->commercialNetworkId = CommercialNetworkIdentity::new();

        $updateOutletCommand = self::makeUpdateOutletCommand();

        // Assert
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessageMatches('/.*CommercialNetwork.*/');

        // Act
        $updateOutletCommand->execute($outlet->getId(), $outletDto);
    }

    protected static function makeUpdateOutletCommand(): UpdateOutletCommand
    {
        return new UpdateOutletCommand(
            OutletAppEnv::getOutletRepository(),
            OutletAppEnv::getCommercialNetworkRepository()
        );
    }
}
