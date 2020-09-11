<?php

declare(strict_types=1);

namespace App\Controller;

use Monitorings\File\Domain\FileService;
use Monitorings\Identity;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(path="/file", name="file_")
 */
class FileController extends BaseController
{
    private FileService $fileService;

    public function __construct(
        FileService $fileService
    ) {
        $this->fileService = $fileService;
    }

    /**
     * @Route("/{id}", name="view", requirements={ "id"="[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}" }, methods={ "get" })
     */
    public function viewAction(string $id): Response
    {
        $file = $this->fileService->getFileOrFail(
            Identity::fromString($id)
        );

        /** @noinspection PhpUnhandledExceptionInspection */
        $fileContent = $this->fileService->getFileContent($file);

        $response = new Response();
        $disposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_INLINE, $file->getOriginalName());
        $response->headers->set('Content-Disposition', $disposition);
        $response->headers->set('Content-Type', 'image/png');
        $response->setContent($fileContent);
        return $response;
    }
}
