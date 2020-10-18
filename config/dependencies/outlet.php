<?php

declare(strict_types=1);

use Domain\Outlet\App\CommercialNetwork\CreateCommercialNetworkCommand;
use Domain\Outlet\App\Outlet\CreateOutletCommand;
use Domain\Outlet\App\CommercialNetwork\UpdateCommercialNetworkCommand;
use Domain\Outlet\App\Outlet\UpdateOutletCommand;
use Domain\Outlet\Data\DoctrineCommercialNetworkRepository;
use Domain\Outlet\Data\DoctrineOutletRepository;
use Domain\Outlet\Domain\CommercialNetwork;
use Domain\Outlet\Domain\CommercialNetworkRepository;
use Domain\Outlet\Domain\Outlet;
use Domain\Outlet\Domain\OutletRepository;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/** @var ContainerBuilder $container */

$container
    ->register(OutletRepository::class, DoctrineOutletRepository::class)
    ->setFactory([new Reference('doctrine.orm.default_entity_manager'), 'getRepository'])
    ->addArgument(Outlet::class)
;

$container
    ->register(CommercialNetworkRepository::class, DoctrineCommercialNetworkRepository::class)
    ->setFactory([new Reference('doctrine.orm.default_entity_manager'), 'getRepository'])
    ->addArgument(CommercialNetwork::class)
;

$container
    ->register(UpdateOutletCommand::class)
    ->setAutowired(true)
;

$container
    ->register(UpdateCommercialNetworkCommand::class)
    ->setAutowired(true)
;

$container
    ->register(CreateOutletCommand::class)
    ->setAutowired(true)
;

$container
    ->register(CreateCommercialNetworkCommand::class)
    ->setAutowired(true)
;
