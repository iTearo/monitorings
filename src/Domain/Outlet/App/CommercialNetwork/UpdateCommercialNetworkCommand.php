<?php

declare(strict_types=1);

namespace Domain\Outlet\App\CommercialNetwork;

use App\Exception\NotFoundException;
use Domain\File\Domain\File;
use Domain\File\Domain\FileService;
use Domain\Common\Identity;
use Domain\Outlet\App\Dto\CommercialNetworkDto;
use Domain\Outlet\Domain\CommercialNetwork;
use Domain\Outlet\Domain\CommercialNetworkRepository;

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
