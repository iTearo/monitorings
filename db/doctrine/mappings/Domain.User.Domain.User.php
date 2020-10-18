<?php

declare(strict_types=1);

/** @var ClassMetadata $metadata  */

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;
use Domain\User\Data\DoctrineUserRepository;

$builder = new ClassMetadataBuilder($metadata);

$builder->setTable(DoctrineUserRepository::TABLE);
$builder->setCustomRepositoryClass(DoctrineUserRepository::class);

$builder->createField('id', Types::INTEGER)->makePrimaryKey()->generatedValue()->build();

$builder->addField('email', Types::STRING);

$builder->addField('roles', Types::JSON);

$builder->addField('password', Types::STRING);

$builder->addField('isVerified', Types::BOOLEAN);

$builder->addUniqueConstraint(['email'], 'email');
