<?php

declare(strict_types=1);

namespace Monitorings;

trait CreatedAndUpdatedDatetime
{
    use CreatedDatetime;

    protected ?\DateTimeInterface $updatedAt = null;

    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }
}
