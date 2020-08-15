<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\RequestValidationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

abstract class BaseController extends AbstractController
{
    protected const FORM_ATTRIBUTE = 'form';

    public function makeForm(string $formType, object $entity): FormInterface
    {
        /** @var FormBuilderInterface $formBuilder */
        $formBuilder = $this->container->get('form.factory')->createBuilder();

        return $formBuilder->create(self::FORM_ATTRIBUTE, $formType)
            ->setData(clone $entity)
            ->getForm();
    }

    /**
     * @throws RequestValidationException
     */
    public function validateRequest(Request $request, FormInterface $form): void
    {
        $form->handleRequest($request);
        if ($form->isSubmitted() && ! $form->isValid()) {
            throw new RequestValidationException();
        }
    }
}
