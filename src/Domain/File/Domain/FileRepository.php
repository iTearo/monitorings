<?php

declare(strict_types=1);

namespace Domain\File\Domain;

use App\Exception\NotFoundException;
use Domain\Common\Identity;

interface FileRepository
{
    public function get(Identity $id): ?File;

    /**
     * @throws NotFoundException
     */
    public function getByIdOrFail(Identity $id): File;

    /**
     * @throws NotFoundException
     */
    public function getByIdOrFailAllowNull(?Identity $id): ?File;

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
