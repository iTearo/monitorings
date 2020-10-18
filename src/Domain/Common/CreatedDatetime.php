<?php

declare(strict_types=1);

namespace Domain\Common;

trait CreatedDatetime
{
    protected ?\DateTimeInterface $createdAt = null;

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }
}
