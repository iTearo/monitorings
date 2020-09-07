<?php

declare(strict_types=1);

namespace Monitorings\Outlet\App\Outlet;

use App\Exception\NotFoundException;
use Monitorings\Identity;
use Monitorings\Outlet\App\Dto\AddressDto;
use Monitorings\Outlet\App\Dto\OutletDto;
use Monitorings\Outlet\Domain\CommercialNetwork;
use Monitorings\Outlet\Domain\CommercialNetworkRepository;
use Monitorings\Outlet\Domain\OutletRepository;
use Monitorings\Outlet\OutletEnv;
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
        self::assertNotNull($outletDto);
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

        $commercialNetworkRepository = self::getContainer()->get(CommercialNetworkRepository::class);

        $createOutletCommand = new CreateOutletCommand($this->makeOutletRepository(), $commercialNetworkRepository);

        // Assert
        $this->expectException(NotFoundException::class);

        // Act
        $createOutletCommand->execute($outletDto);
    }

    protected function makeOutletRepository(): OutletRepository
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->prophesize(OutletRepository::class)->reveal();
    }
}
