<?php

declare(strict_types=1);

namespace Monitorings\Outlet\Domain;

use Monitorings\CreatedAndUpdatedDatetime;
use Monitorings\Identity;

class CommercialNetwork
{
    use CreatedAndUpdatedDatetime;

    private Identity $id;

    private string $title;

    public function __construct(
        string $title
    ) {
        $this->id = Identity::new();
        $this->title = $title;
    }

    public function getId(): Identity
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
}
