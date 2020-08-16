<?php

declare(strict_types=1);

namespace App\Doctrine\EntityListener;

class CreateAndUpdateListener
{
    public static function handleCreate($entity): void
    {
        $dt = \DateTimeImmutable::createFromFormat('U', (string) time());

        self::setCreatedAtCallable($dt)->call($entity);
        self::setUpdatedAtCallable($dt)->call($entity);
    }

    public static function handleUpdate($entity): void
    {
        $dt = \DateTimeImmutable::createFromFormat('U', (string) time());

        self::setUpdatedAtCallable($dt)->call($entity);
    }

    private static function setCreatedAtCallable(\DateTimeInterface $dateTime): \Closure
    {
        return function () use ($dateTime) {
            $createdAtPropertyName = 'createdAt';

            if (property_exists($this, $createdAtPropertyName) === false) {
                return;
            }

            $property = (new \ReflectionClass($this))->getProperty($createdAtPropertyName);
            $property->setAccessible(true);
            $isInitialized = $property->isInitialized($this);

            if ($isInitialized === false || $this->{$createdAtPropertyName} === null) {
                $this->{$createdAtPropertyName} = $dateTime;
            }
        };
    }

    private static function setUpdatedAtCallable(\DateTimeInterface $dateTime): \Closure
    {
        return function () use ($dateTime) {
            $updatedAtPropertyName = 'updatedAt';

            if (property_exists($this, $updatedAtPropertyName) === false) {
                return;
            }

            $this->{$updatedAtPropertyName} = $dateTime;
        };
    }
}
