<?php

declare(strict_types=1);

/** @var ClassMetadata $metadata  */

use App\Doctrine\ClassMetadataBuilderHelper;
use App\Doctrine\Type\AddressType;
use App\Doctrine\Type\IdentityType;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;
use Monitorings\Outlet\Data\DoctrineOutletRepository;
use Monitorings\Outlet\Domain\CommercialNetwork;

$builder = new ClassMetadataBuilder($metadata);

$builder->setTable(DoctrineOutletRepository::TABLE);
$builder->setCustomRepositoryClass(DoctrineOutletRepository::class);

$builder->createField('id', IdentityType::TYPE_NAME)->makePrimaryKey()->build();

$builder->addManyToOne('commercialNetwork', CommercialNetwork::class);

$builder->createField('address', AddressType::TYPE_NAME)->build();

ClassMetadataBuilderHelper::addCreatedAndUpdatedDatetimeFields($builder);
