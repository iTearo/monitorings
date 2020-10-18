<?php

declare(strict_types=1);

namespace Domain\Common;

use Ramsey\Uuid\Uuid;

class Identity
{
    private string $value;

    private function __construct(string $value)
    {
        self::assertGuidString($value);

        $this->value = $value;
    }

    private static function assertGuidString(string $guid): void
    {
        if ( ! Uuid::isValid($guid)) {
            throw new \InvalidArgumentException('Wrong Identity value');
        }
    }

    public function isEqualTo(self $identity): bool
    {
        return $this->value === $identity->value;
    }

    public static function new(): self
    {
        return new self(
            Uuid::uuid4()->toString()
        );
    }

    public static function fromString(string $guid): self
    {
        return new self($guid);
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function __toString()
    {
        return $this->toString();
    }
}
