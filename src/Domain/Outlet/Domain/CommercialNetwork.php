<?php

declare(strict_types=1);

namespace Domain\Outlet\Domain;

use Domain\Common\CreatedAndUpdatedDatetime;
use Domain\File\Domain\File;

class CommercialNetwork
{
    use CreatedAndUpdatedDatetime;

    private CommercialNetworkIdentity $id;

    private string $title;

    private ?File $logotypeFile = null;

    public function __construct(
        string $title
    ) {
        $this->id = CommercialNetworkIdentity::new();
        $this->title = $title;
    }

    public function getId(): CommercialNetworkIdentity
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

    public function getLogotypeFile(): ?File
    {
        return $this->logotypeFile;
    }

    public function setLogotypeFile(?File $logotypeFile): void
    {
        $this->logotypeFile = $logotypeFile;
    }
}
