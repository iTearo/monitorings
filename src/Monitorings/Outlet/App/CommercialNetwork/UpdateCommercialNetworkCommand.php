<?php

declare(strict_types=1);

namespace Monitorings\Outlet\App\CommercialNetwork;

use App\Exception\NotFoundException;
use Monitorings\File\Domain\File;
use Monitorings\File\Domain\FileService;
use Monitorings\Identity;
use Monitorings\Outlet\App\Dto\CommercialNetworkDto;
use Monitorings\Outlet\Domain\CommercialNetwork;
use Monitorings\Outlet\Domain\CommercialNetworkRepository;

class UpdateCommercialNetworkCommand
{
    private FileService $fileService;

    private CommercialNetworkRepository $commercialNetworkRepository;

    public function __construct(
        FileService $fileService,
        CommercialNetworkRepository $commercialNetworkRepository
    ) {
        $this->fileService = $fileService;
        $this->commercialNetworkRepository = $commercialNetworkRepository;
    }

    /**
     * @throws NotFoundException
     */
    public function execute(Identity $id, CommercialNetworkDto $commercialNetworkDto): CommercialNetwork
    {
        $commercialNetwork = $this->commercialNetworkRepository->getByIdOrFail($id);

        $prevLogotypeFile = $commercialNetwork->getLogotypeFile();

        $commercialNetwork->setTitle($commercialNetworkDto->title);

        $commercialNetwork->setLogotypeFile(
            $this->fileService->getFileOrFailAllowNull($commercialNetworkDto->logotypeFileId)
        );

        $this->commercialNetworkRepository->save($commercialNetwork);

        if ($prevLogotypeFile !== null) {
            $this->deletePervLogotypeFile($commercialNetwork->getLogotypeFile(), $prevLogotypeFile);
        }

        return $commercialNetwork;
    }

    private function deletePervLogotypeFile(?File $currentFile, File $prevFile): void
    {
        if ($currentFile === null || $currentFile->getId() !== $prevFile->getId()) {
            $this->fileService->deleteFile($prevFile);
        }
    }
}
