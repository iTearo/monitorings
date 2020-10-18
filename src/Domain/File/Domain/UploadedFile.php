<?php

declare(strict_types=1);

namespace Domain\File\Domain;

use Domain\File\Domain\Exceptions\InvalidMimeTypeException;

final class UploadedFile
{
    protected string $content;

    protected string $mimeType;

    protected ?string $originalName;

    public function __construct(
        string $content,
        string $mimeType,
        string $originalName = null
    ) {
        $this->content = $content;
        $this->mimeType = $mimeType;
        $this->originalName = $originalName;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    public function getOriginalName(): ?string
    {
        return $this->originalName;
    }

    protected static function isValid(string $mimeType): bool
    {
        return MimeType::isAllowed($mimeType);
    }

    public static function detectMimeType(string $content): string
    {
        return finfo_buffer(finfo_open(), $content, FILEINFO_MIME_TYPE);
    }

    public static function createFromFile(\SplFileInfo $file, string $originalName): self
    {
        $content = file_get_contents(
            $file->getRealPath()
        );

        $mimeType = self::detectMimeType($content);
        if (!self::isValid($mimeType)) {
            throw new InvalidMimeTypeException($mimeType);
        }

        return new self($content, $mimeType, $originalName);
    }
}
