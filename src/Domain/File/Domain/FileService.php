<?php

declare(strict_types=1);

namespace Domain\File\Domain;

use App\Exception\NotFoundException;
use League\Flysystem\FileNotFoundException;
use League\Flysystem\FilesystemInterface;
use Domain\Common\Identity;
use Domain\User\Domain\User;

class FileService
{
    private FilesystemInterface $filesystem;

    protected FileRepository $fileRepository;

    public function __construct(
        FilesystemInterface $filesystem,
        FileRepository $fileRepository
    ) {
        $this->filesystem = $filesystem;
        $this->fileRepository = $fileRepository;
    }

    public function getFile(Identity $id): ?File
    {
        return $this->fileRepository->get($id);
    }

    /**
     * @throws NotFoundException
     */
    public function getFileOrFail(Identity $id): File
    {
        return $this->fileRepository->getByIdOrFail($id);
    }

    /**
     * @throws NotFoundException
     */
    public function getFileOrFailAllowNull(?Identity $id): ?File
    {
        return $this->fileRepository->getByIdOrFailAllowNull($id);
    }

    public function saveFile(UploadedFile $uploadedFile, ?User $user = null): File
    {
        $file = $this->createFile($uploadedFile, $user);
        $this->fileRepository->save($file);
        $file->computePath();
        $this->filesystem->put(
            $file->getPath(),
            $uploadedFile->getContent(),
            ['ContentType' => $uploadedFile->getMimeType()]
        );
        $file->setStatus(FileStatus::UPLOADED);
        $this->fileRepository->save($file);

        return $file;
    }

    private function createFile(
        UploadedFile $uploadedFile,
        ?User $user = null
    ): File {
        return new File(
            $uploadedFile->getMimeType(),
            \sha1($uploadedFile->getContent()),
            \md5($uploadedFile->getContent()),
            \strlen($uploadedFile->getContent()),
            $uploadedFile->getOriginalName(),
            $user,
        );
    }

    /**
     * @throws FileNotFoundException
     */
    public function getFileContent(File $file): string
    {
        return $this->filesystem->read($file->getPath());
    }

    /**
     * @throws FileNotFoundException
     */
    public function getFileTmpPath(File $file): string
    {
        $fileTmpPath = '/tmp/' . $file->getId();

        if (file_exists($fileTmpPath) === false) {
            $fileContent = $this->getFileContent($file);
            file_put_contents($fileTmpPath, $fileContent);
        }

        return $fileTmpPath;
    }

    public function deleteFile(File $file): void
    {
        $path = $file->getPath();
        $this->fileRepository->delete($file);

        try {
            $this->filesystem->delete($path);

        } catch (FileNotFoundException $e) {
            // TODO: implement logging here
        }
    }
}
