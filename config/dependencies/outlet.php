<?php

declare(strict_types=1);

use Monitorings\Outlet\App\CommercialNetwork\CreateCommercialNetworkCommand;
use Monitorings\Outlet\App\Outlet\CreateOutletCommand;
use Monitorings\Outlet\App\CommercialNetwork\UpdateCommercialNetworkCommand;
use Monitorings\Outlet\App\Outlet\UpdateOutletCommand;
use Monitorings\Outlet\Data\DoctrineCommercialNetworkRepository;
use Monitorings\Outlet\Data\DoctrineOutletRepository;
use Monitorings\Outlet\Domain\CommercialNetwork;
use Monitorings\Outlet\Domain\CommercialNetworkRepository;
use Monitorings\Outlet\Domain\Outlet;
use Monitorings\Outlet\Domain\OutletRepository;
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
