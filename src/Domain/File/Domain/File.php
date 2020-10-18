<?php

declare(strict_types=1);

namespace Domain\File\Domain;

use Domain\Common\CreatedAndUpdatedDatetime;
use Domain\File\Domain\Exceptions\UnknownFileStatusException;
use Domain\User\Domain\User;

class File
{
    use CreatedAndUpdatedDatetime;

    private FileIdentity $id;

    private ?string $path = null;

    private ?int $size;

    private string $mimeType;

    private ?User $author;

    private string $sha1;

    private string $md5;

    private int $status;

    private ?string $originalName;

    public function __construct(
        string $mimeType,
        string $sha1,
        string $md5,
        ?int $size = null,
        ?string $originalName = null,
        ?User $author = null
    ) {
        $this->id = FileIdentity::new();
        $this->mimeType = $mimeType;
        $this->sha1 = $sha1;
        $this->md5 = $md5;
        $this->size = $size;
        $this->status = FileStatus::PROCESSING;
        $this->originalName = $originalName;
        $this->author = $author;
    }

    public function getId(): FileIdentity
    {
        return $this->id;
    }

    public function getSha1(): string
    {
        return $this->sha1;
    }

    public function getMd5(): string
    {
        return $this->md5;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function getOriginalName(): ?string
    {
        return $this->originalName;
    }

    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function getFilenameWithExtension(): ?string
    {
        if ($this->originalName) {
            return $this->getOriginalName();
        }

        $filenameWithExt = $this->getFilenameFromPath();
        if ($this->getExtension()) {
            $filenameWithExt .= '.' . $this->getExtension();
        }
        return $filenameWithExt;
    }

    public function getFilenameFromPath(): ?string
    {
        if ($this->getPath() === null) {
            return null;
        }
        return \pathinfo($this->getPath(), PATHINFO_FILENAME);
    }

    public function getExtension(): ?string
    {
        if ($this->getPath() === null) {
            return null;
        }
        return \pathinfo($this->getPath(), PATHINFO_EXTENSION);
    }

    public function setStatus(int $status): void
    {
        if (!FileStatus::isValid($status)) {
            throw new UnknownFileStatusException($status);
        }

        $this->status = $status;
    }

    public function computePath(): void
    {
        if ($this->path !== null) {
            return;
        }

        $extension = MimeType::getExtension($this->mimeType);

        $id = $this->id->toString();

        $parts = [];
        $parts[] = substr($id, 0, 2);
        $parts[] = substr($id, 2, 2);
        $filename = $this->id;
        if ($extension !== null) {
            $filename = sprintf('%s.%s', $id, $extension);
        }

        $parts[] = $filename;

        $this->path = implode('/', $parts);
    }
}
