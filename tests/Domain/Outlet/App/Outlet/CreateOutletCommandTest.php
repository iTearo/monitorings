<?php

declare(strict_types=1);

namespace Domain\Outlet\App\Outlet;

use App\Exception\NotFoundException;
use Domain\Common\Identity;
use Domain\Outlet\App\Dto\AddressDto;
use Domain\Outlet\App\Dto\OutletDto;
use Domain\Outlet\Domain\CommercialNetwork;
use Domain\Outlet\Domain\CommercialNetworkRepository;
use Domain\Outlet\Domain\OutletRepository;
use Domain\Outlet\OutletAppEnv;
use Domain\Outlet\OutletEnv;
use Prophecy\Prophecy\MethodProphecy;
use Prophecy\Prophecy\ObjectProphecy;
use TestTools\TestCase;

class CreateOutletCommandTest extends TestCase
{
    public function test_execute(): void
    {
        // Arrange
        $commercialNetwork = new CommercialNetwork('title');

        $outletDto = OutletEnv::createOutletDto();
        $outletDto->commercialNetworkId = $commercialNetwork->getId();

        $commercialNetworkRepository = $this->prophesize(CommercialNetworkRepository::class);

        $getByIdOrFailMethod = (new MethodProphecy(
                $commercialNetworkRepository,
                'getByIdOrFail',
                [$commercialNetwork->getId()]
            ))
            ->willReturn($commercialNetwork);

        /** @var CommercialNetworkRepository|ObjectProphecy $commercialNetworkRepository */
        $commercialNetworkRepository = $commercialNetworkRepository->reveal();

        $createOutletCommand = new CreateOutletCommand($this->makeOutletRepository(), $commercialNetworkRepository);

        // Act
        $outlet = $createOutletCommand->execute($outletDto);

        // Assert
        $getByIdOrFailMethod->shouldBeCalledOnce();
        self::assertEquals($outlet->getCommercialNetwork()->getId(), $commercialNetwork->getId());
        self::assertEquals($outlet->getAddress()->getBuilding(), $outletDto->address->building);
        self::assertEquals($outlet->getAddress()->getStreet(), $outletDto->address->street);
        self::assertEquals($outlet->getAddress()->getLocality(), $outletDto->address->locality);
    }

    public function test_execute_commercialNetworkNotFound(): void
    {
        // Arrange
        $outletDto = new OutletDto();
        $outletDto->address = new AddressDto();
        $outletDto->commercialNetworkId = Identity::new();

        $createOutletCommand = new CreateOutletCommand(
            $this->makeOutletRepository(),
            OutletAppEnv::getCommercialNetworkRepository()
        );

        // Assert
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessageMatches('/.*CommercialNetwork.*/');

        // Act
        $createOutletCommand->execute($outletDto);
    }

    protected function makeOutletRepository(): OutletRepository
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->prophesize(OutletRepository::class)->reveal();
    }
}
