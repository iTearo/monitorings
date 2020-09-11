<?php

declare(strict_types=1);

namespace Monitorings\File\Data;

use App\Doctrine\Repository;
use App\Exception\NotFoundException;
use Monitorings\File\Domain\File;
use Monitorings\File\Domain\FileRepository;
use Monitorings\Identity;

class DoctrineFileRepository extends Repository implements FileRepository
{
    public const TABLE = 'file_upload';

    public function get(Identity $id): ?File
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->find($id->toString());
    }

    /**
     * @throws NotFoundException
     */
    public function getByIdOrFail(Identity $id): File
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
    public function getByIdOrFailAllowNull(?Identity $id): ?File
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
