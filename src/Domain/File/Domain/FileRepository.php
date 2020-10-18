<?php

declare(strict_types=1);

namespace Domain\File\Domain;

use App\Exception\NotFoundException;

interface FileRepository
{
    public function get(FileIdentity $id): ?File;

    /**
     * @throws NotFoundException
     */
    public function getByIdOrFail(FileIdentity $id): File;

    /**
     * @throws NotFoundException
     */
    public function getByIdOrFailAllowNull(?FileIdentity $id): ?File;

    public function save(File $file): void;

    public function delete(File $file): void;

    /**
     * @return File[]
     */
    public function getAllByLegalEntity(int $legalEntityId): array;

    /**
     * @return File[]
     */
    public function getAllByAuthor(string $authorId): array;
}
