<?php

declare(strict_types=1);

/** @var ClassMetadata $metadata  */

use App\Doctrine\ClassMetadataBuilderHelper;
use App\Doctrine\Type\IdentityType;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;
use Domain\File\Domain\File;
use Domain\Outlet\Data\DoctrineCommercialNetworkRepository;

$builder = new ClassMetadataBuilder($metadata);

$builder->setTable(DoctrineCommercialNetworkRepository::TABLE);
$builder->setCustomRepositoryClass(DoctrineCommercialNetworkRepository::class);

$builder->createField('id', IdentityType::TYPE_NAME)->makePrimaryKey()->build();

$builder->addField('title', Types::STRING);

$builder->addOwningOneToOne('logotypeFile', File::class);

ClassMetadataBuilderHelper::addCreatedAndUpdatedDatetimeFields($builder);
