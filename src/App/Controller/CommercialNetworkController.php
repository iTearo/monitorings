<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\NotFoundException;
use App\Exception\RequestValidationException;
use App\Form\CommercialNetworkFormType;
use Monitorings\Identity;
use Monitorings\Outlet\App\CommercialNetwork\CreateCommercialNetworkCommand;
use Monitorings\Outlet\App\Dto\CommercialNetworkDto;
use Monitorings\Outlet\App\CommercialNetwork\UpdateCommercialNetworkCommand;
use Monitorings\Outlet\Domain\CommercialNetwork;
use Monitorings\Outlet\Domain\CommercialNetworkRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(path="/commercialNetwork", name="commercial_network_")
 */
class CommercialNetworkController extends BaseController
{
    private CreateCommercialNetworkCommand $createCommercialNetworkCommand;

    private UpdateCommercialNetworkCommand $updateCommercialNetworkCommand;

    private CommercialNetworkRepository $commercialNetworkRepository;

    public function __construct(
        CreateCommercialNetworkCommand $createCommercialNetworkCommand,
        UpdateCommercialNetworkCommand $updateCommercialNetworkCommand,
        CommercialNetworkRepository $commercialNetworkRepository
    ) {
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

                $commercialNetwork = $this->createCommercialNetworkCommand->execute(
                    self::createCommercialNetworkDto($request)
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
        $entity = $this->commercialNetworkRepository->getByIdOrFail(Identity::fromString($id));

        $form = $this->makeForm(CommercialNetworkFormType::class, $entity);

        if ($request->isMethod('post')) {
            try {
                $this->validateRequest($request, $form);

                $commercialNetwork = $this->updateCommercialNetworkCommand->execute(
                    Identity::fromString($id),
                    self::createCommercialNetworkDto($request)
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
        ]);
    }

    private static function createCommercialNetworkDto(Request $request): CommercialNetworkDto
    {
        parse_str(urldecode($request->getContent()), $requestData);
        return CommercialNetworkDto::createFromArray($requestData[self::FORM_ATTRIBUTE]);
    }
}
