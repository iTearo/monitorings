<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\NotFoundException;
use App\Exception\RequestValidationException;
use App\Form\OutletFormType;
use Monitorings\Identity;
use Monitorings\Outlet\App\Dto\OutletDto;
use Monitorings\Outlet\App\UpdateOutletCommand;
use Monitorings\Outlet\Domain\OutletRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(path="/outlet", name="outlet_")
 */
class OutletController extends BaseController
{
    private UpdateOutletCommand $updateOutletCommand;

    private OutletRepository $outletRepository;

    public function __construct(
        UpdateOutletCommand $updateOutletCommand,
        OutletRepository $outletRepository
    ) {
        $this->updateOutletCommand = $updateOutletCommand;
        $this->outletRepository = $outletRepository;
    }

    /**
     * @Route("/", name="list", methods={ "get" })
     */
    public function listAction(Request $request): Response
    {
        $pageNumber = $request->get('page', 1);

        $pagination = $this->outletRepository->getAllPaginated((int) $pageNumber);

        return $this->render('pages/outlet/list.html.twig', [
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
        $entity = $this->outletRepository->getByIdOrFail(Identity::fromString($id));

        $form = $this->makeForm(OutletFormType::class, $entity);

        if ($request->isMethod('post')) {
            try {
                $this->validateRequest($request, $form);

                $this->updateOutletCommand->execute(
                    Identity::fromString($id),
                    self::createOutletDto($request)
                );

                $this->addFlash('success', 'Успешно сохранено');

                return $this->redirect($request->getRequestUri());

            } catch (RequestValidationException $exception) {
                $this->addFlash('error', 'Исправьте неправильно заполненные поля');
            }
        }

        return $this->render('pages/outlet/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private static function createOutletDto(Request $request): OutletDto
    {
        parse_str(urldecode($request->getContent()), $requestData);
        return OutletDto::createFromArray($requestData[self::FORM_ATTRIBUTE]);
    }
}
