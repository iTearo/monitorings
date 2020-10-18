<?php

declare(strict_types=1);

use App\Doctrine\ClassMetadataBuilderHelper;
use App\Doctrine\Type\FileIdentityType;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;
use Domain\File\Data\DoctrineFileRepository;
use Domain\User\Domain\User;

/** @var ClassMetadata $metadata */
$builder = new ClassMetadataBuilder($metadata);

$builder->setTable(DoctrineFileRepository::TABLE);
$builder->setCustomRepositoryClass(DoctrineFileRepository::class);

$builder->createField('id', FileIdentityType::TYPE_NAME)->makePrimaryKey()->build();

$builder->addField('md5', Types::STRING);
$builder->addField('sha1', Types::STRING);
$builder->addField('size', Types::INTEGER);
$builder->addField('path', Types::STRING);
$builder->addField('status', Types::INTEGER);
$builder->addField('originalName', Types::STRING);
$builder->addField('mimeType', Types::STRING, ['columnName' => 'mime_type']);

$builder->addManyToOne('author', User::class);

ClassMetadataBuilderHelper::addCreatedAndUpdatedDatetimeFields($builder);
