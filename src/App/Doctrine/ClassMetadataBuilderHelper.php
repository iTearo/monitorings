<?php

declare(strict_types=1);

namespace App\Doctrine;

use App\Doctrine\EntityListener\CreateAndUpdateListener;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;

class ClassMetadataBuilderHelper
{
    public static function addCreatedAndUpdatedDatetimeFields(ClassMetadataBuilder $builder): void
    {
        static::addCreatedDatetimeField($builder);
        static::addUpdatedDatetimeField($builder);
    }

    public static function addCreatedDatetimeField(ClassMetadataBuilder $builder): void
    {
        $builder->addField('createdAt', Types::DATETIME_IMMUTABLE);

        /** @noinspection PhpUnhandledExceptionInspection */
        $builder->getClassMetadata()->addEntityListener(Events::prePersist, CreateAndUpdateListener::class, 'handleCreate');
    }

    public static function addUpdatedDatetimeField(ClassMetadataBuilder $builder): void
    {
        $builder->addField('updatedAt', Types::DATETIME_IMMUTABLE);

        /** @noinspection PhpUnhandledExceptionInspection */
        $builder->getClassMetadata()->addEntityListener(Events::preUpdate, CreateAndUpdateListener::class, 'handleUpdate');
    }
}
