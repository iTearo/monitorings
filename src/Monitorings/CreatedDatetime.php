<?php

declare(strict_types=1);

namespace Monitorings;

trait CreatedDatetime
{
    protected ?\DateTimeInterface $createdAt = null;

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }
}
