<?php

declare(strict_types=1);

namespace Domain\File\Data;

use App\Doctrine\Repository;
use App\Exception\NotFoundException;
use Domain\File\Domain\File;
use Domain\File\Domain\FileIdentity;
use Domain\File\Domain\FileRepository;

class DoctrineFileRepository extends Repository implements FileRepository
{
    public const TABLE = 'file_upload';

    public function get(FileIdentity $id): ?File
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->find($id->toString());
    }

    /**
     * @throws NotFoundException
     */
    public function getByIdOrFail(FileIdentity $id): File
    {
        $this->assertFoundByAttribute(
            $file = $this->get($id),
            $id,
            'id'
        );

        return $file;
    }

    /**
     * @throws NotFoundException
     */
    public function getByIdOrFailAllowNull(?FileIdentity $id): ?File
    {
        if ($id === null) {
            return null;
        }

        return $this->getByIdOrFail($id);
    }

    /**
     * @return File[]
     */
    public function getAllByLegalEntity(int $legalEntityId): array
    {
        return $this->findBy(['legalEntity' => $legalEntityId], ['id' => 'DESC']);
    }

    /**
     * @return File[]
     */
    public function getAllByAuthor(string $authorId): array
    {
        return $this->findBy(['author' => $authorId], ['id' => 'DESC']);
    }
}
