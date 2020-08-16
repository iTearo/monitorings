<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\NotFoundException;
use App\Exception\RequestValidationException;
use App\Form\OutletFormType;
use Monitorings\Identity;
use Monitorings\Outlet\App\CreateOutletCommand;
use Monitorings\Outlet\App\Dto\OutletDto;
use Monitorings\Outlet\App\UpdateOutletCommand;
use Monitorings\Outlet\Domain\Address;
use Monitorings\Outlet\Domain\CommercialNetwork;
use Monitorings\Outlet\Domain\Outlet;
use Monitorings\Outlet\Domain\OutletRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(path="/outlet", name="outlet_")
 */
class OutletController extends BaseController
{
    private CreateOutletCommand $createOutletCommand;

    private UpdateOutletCommand $updateOutletCommand;

    private OutletRepository $outletRepository;

    public function __construct(
        CreateOutletCommand $createOutletCommand,
        UpdateOutletCommand $updateOutletCommand,
        OutletRepository $outletRepository
    ) {
        $this->createOutletCommand = $createOutletCommand;
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
     * @Route("/new", name="create", methods={ "get", "post" })
     *
     * @throws NotFoundException
     */
    public function createAction(Request $request): Response
    {
        $form = $this->makeForm(
            OutletFormType::class,
            self::makeEmptyOutlet()
        );

        if ($request->isMethod('post')) {
            try {
                $this->validateRequest($request, $form);

                $outlet = $this->createOutletCommand->execute(
                    self::createOutletDto($request)
                );

                $this->successSaving();

                return $this->redirectToRoute('outlet_edit', ['id' => $outlet->getId()]);

            } catch (RequestValidationException $exception) {
                $this->formInvalid();
            }
        }

        return $this->render('pages/outlet/edit.html.twig', [
            'isNew' => true,
            'form' => $form->createView(),
        ]);
    }

    private static function makeEmptyOutlet(): Outlet
    {
        return new Outlet(
            new CommercialNetwork(''),
            new Address('', '', '')
        );
    }

    /**
     * @Route("/{id}", name="edit", requirements={ "id"="[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}" }, methods={ "get", "post" })
     *
     * @throws NotFoundException
     */
    public function editAction($id, Request $request): Response
    {
        $form = $this->makeForm(
            OutletFormType::class,
            $this->outletRepository->getByIdOrFail(Identity::fromString($id))
        );

        if ($request->isMethod('post')) {
            try {
                $this->validateRequest($request, $form);

                $outlet = $this->updateOutletCommand->execute(
                    Identity::fromString($id),
                    self::createOutletDto($request)
                );

                $this->successSaving();

                return $this->redirectToRoute('outlet_edit', ['id' => $outlet->getId()]);

            } catch (RequestValidationException $exception) {
                $this->formInvalid();
            }
        }

        return $this->render('pages/outlet/edit.html.twig', [
            'isNew' => false,
            'form' => $form->createView(),
        ]);
    }

    private static function createOutletDto(Request $request): OutletDto
    {
        parse_str(urldecode($request->getContent()), $requestData);
        return OutletDto::createFromArray($requestData[self::FORM_ATTRIBUTE]);
    }
}
