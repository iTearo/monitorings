<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\NotFoundException;
use App\Exception\RequestValidationException;
use App\Form\CommercialNetworkFormType;
use Monitorings\Identity;
use Monitorings\Outlet\App\Dto\CommercialNetworkDto;
use Monitorings\Outlet\App\UpdateCommercialNetworkCommand;
use Monitorings\Outlet\Domain\CommercialNetworkRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(path="/commercialNetwork", name="commercial_network_")
 */
class CommercialNetworkController extends BaseController
{
    private UpdateCommercialNetworkCommand $updateCommercialNetworkCommand;

    private CommercialNetworkRepository $commercialNetworkRepository;

    public function __construct(
        UpdateCommercialNetworkCommand $updateCommercialNetworkCommand,
        CommercialNetworkRepository $commercialNetworkRepository
    ) {
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

                $this->updateCommercialNetworkCommand->execute(
                    Identity::fromString($id),
                    self::createCommercialNetworkDto($request)
                );

                $this->addFlash('success', 'Успешно сохранено');

                return $this->redirect($request->getRequestUri());

            } catch (RequestValidationException $exception) {
                $this->addFlash('error', 'Исправьте неправильно заполненные поля');
            }
        }

        return $this->render('pages/commercial_network/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private static function createCommercialNetworkDto(Request $request): CommercialNetworkDto
    {
        parse_str(urldecode($request->getContent()), $requestData);
        return CommercialNetworkDto::createFromArray($requestData[self::FORM_ATTRIBUTE]);
    }
}
