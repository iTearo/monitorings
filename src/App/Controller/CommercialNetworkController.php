<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\NotFoundException;
use App\Exception\RequestValidationException;
use App\Form\CommercialNetworkFormType;
use Domain\File\Domain\FileService;
use Domain\File\Domain\UploadedFile;
use Domain\Outlet\App\CommercialNetwork\CreateCommercialNetworkCommand;
use Domain\Outlet\App\Dto\CommercialNetworkDto;
use Domain\Outlet\App\CommercialNetwork\UpdateCommercialNetworkCommand;
use Domain\Outlet\Domain\CommercialNetwork;
use Domain\Outlet\Domain\CommercialNetworkIdentity;
use Domain\Outlet\Domain\CommercialNetworkRepository;
use Domain\User\Domain\User;
use Symfony\Component\HttpFoundation\File\UploadedFile as SymfonyUploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Security;

/**
 * @Route(path="/commercialNetwork", name="commercial_network_")
 */
class CommercialNetworkController extends BaseController
{
    private RouterInterface $router;

    private Security $security;

    private FileService $fileService;

    private CreateCommercialNetworkCommand $createCommercialNetworkCommand;

    private UpdateCommercialNetworkCommand $updateCommercialNetworkCommand;

    private CommercialNetworkRepository $commercialNetworkRepository;

    public function __construct(
        RouterInterface $router,
        Security $security,
        FileService $fileService,
        CreateCommercialNetworkCommand $createCommercialNetworkCommand,
        UpdateCommercialNetworkCommand $updateCommercialNetworkCommand,
        CommercialNetworkRepository $commercialNetworkRepository
    ) {
        $this->router = $router;
        $this->security = $security;
        $this->fileService = $fileService;
        $this->createCommercialNetworkCommand = $createCommercialNetworkCommand;
        $this->updateCommercialNetworkCommand = $updateCommercialNetworkCommand;
        $this->commercialNetworkRepository = $commercialNetworkRepository;
    }

    /**
     * @Route("/", name="list", methods={ "get" })
     */
    public function listAction(Request $request): Response
    {
        $pageNumber = $request->get('page', 1);

        $pagination = $this->commercialNetworkRepository->getAllPaginated((int) $pageNumber);

        return $this->render('pages/commercial_network/list.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/new", name="create", methods={ "get", "post" })
     *
     * @throws NotFoundException
     */
    public function createAction(Request $request): Response
    {
        $form = $this->makeForm(
            CommercialNetworkFormType::class,
            self::makeEmptyCommercialNetwork()
        );

        if ($request->isMethod('post')) {
            try {
                $this->validateRequest($request, $form);

                $commercialNetworkDto = self::createCommercialNetworkDto($request);

                if ($uploadedFile = $this->extractLogotypeFileFromRequest($request)) {
                    $logotypeFile = $this->fileService->saveFile(
                        $uploadedFile,
                        $this->getCurrentUser()
                    );

                    $commercialNetworkDto->logotypeFileId = $logotypeFile->getId();
                }

                $commercialNetwork = $this->createCommercialNetworkCommand->execute(
                    $commercialNetworkDto
                );

                $this->successSaving();

                return $this->redirectToRoute('commercial_network_edit', ['id' => $commercialNetwork->getId()]);

            } catch (RequestValidationException $exception) {
                $this->formInvalid();
            }
        }

        return $this->render('pages/commercial_network/edit.html.twig', [
            'isNew' => true,
            'form' => $form->createView(),
        ]);
    }

    private static function makeEmptyCommercialNetwork(): CommercialNetwork
    {
        return new CommercialNetwork('');
    }

    /**
     * @Route("/{id}", name="edit", requirements={ "id"="[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}" }, methods={ "get", "post" })
     *
     * @throws NotFoundException
     */
    public function editAction($id, Request $request): Response
    {
        $entity = $this->commercialNetworkRepository->getByIdOrFail(CommercialNetworkIdentity::fromString($id));

        $form = $this->makeForm(CommercialNetworkFormType::class, $entity);

        if ($request->isMethod('post')) {
            try {
                $this->validateRequest($request, $form);

                $commercialNetworkDto = self::createCommercialNetworkDto($request);

                if ($uploadedFile = $this->extractLogotypeFileFromRequest($request)) {
                    $logotypeFile = $this->fileService->saveFile(
                        $uploadedFile,
                        $this->getCurrentUser()
                    );

                    $commercialNetworkDto->logotypeFileId = $logotypeFile->getId();

                } elseif ($entity->getLogotypeFile() !== null) {
                    $commercialNetworkDto->logotypeFileId = $entity->getLogotypeFile()->getId();
                }

                $commercialNetwork = $this->updateCommercialNetworkCommand->execute(
                    CommercialNetworkIdentity::fromString($id),
                    $commercialNetworkDto
                );

                $this->successSaving();

                return $this->redirectToRoute('commercial_network_edit', ['id' => $commercialNetwork->getId()]);

            } catch (RequestValidationException $exception) {
                $this->formInvalid();
            }
        }

        return $this->render('pages/commercial_network/edit.html.twig', [
            'isNew' => false,
            'form' => $form->createView(),
            'logotypeFileUrl' => $entity->getLogotypeFile() === null ? null
                : $this->router->generate('file_view', ['id' => $entity->getLogotypeFile()->getId()]),
        ]);
    }

    private function extractLogotypeFileFromRequest(Request $request): ?UploadedFile
    {
        /** @var SymfonyUploadedFile|null $sentFile */
        $sentFile = $request->files->get(self::FORM_ATTRIBUTE)['logotype'];

        if ($sentFile === null) {
            return null;
        }

        return UploadedFile::createFromFile(
            $sentFile,
            $sentFile->getClientOriginalName()
        );
    }

    private function getCurrentUser(): User
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->security->getUser();
    }

    private static function createCommercialNetworkDto(Request $request): CommercialNetworkDto
    {
        return CommercialNetworkDto::createFromArray(
            $request->request->get(self::FORM_ATTRIBUTE)
        );
    }
}
