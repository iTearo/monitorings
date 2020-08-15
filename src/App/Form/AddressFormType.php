<?php

declare(strict_types=1);

namespace App\Form;

use Monitorings\Outlet\Domain\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class AddressFormType extends AbstractType implements DataMapperInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('locality', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Regex([
                        'pattern' => '/^[\p{Cyrillic}0-9\s\-]{3,20}$/u',
                        'message' => 'Значение может содержать только: буквы русского алфавита, цифры, дефис. Длина строки от 3 по 20 символов.'
                    ]),
                ],
            ])

            ->add('street', TextType::class)

            ->add('building', TextType::class, [
                'attr' => [ 'minlength' => 1, 'maxlength' => 8],
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 1, 'max' => 8]),
                ],
            ])

            ->setDataMapper($this)
        ;
    }

    /**
     * @param Address $viewData
     */
    public function mapDataToForms($viewData, iterable $forms): void
    {
        /** @noinspection PhpParamsInspection */
        $forms = iterator_to_array($forms);
        $forms['locality']->setData($viewData ? $viewData->getLocality() : '');
        $forms['street']->setData($viewData ? $viewData->getStreet() : '');
        $forms['building']->setData($viewData ? $viewData->getBuilding() : '');
    }

    /**
     * @param Address $viewData
     */
    public function mapFormsToData(iterable $forms, &$viewData): void
    {
        /** @noinspection PhpParamsInspection */
        $forms = iterator_to_array($forms);
        $viewData = new Address(
            $forms['locality']->getData(),
            $forms['street']->getData(),
            $forms['building']->getData()
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
            'empty_data' => null,
            'translation_domain' => 'outlet'
        ]);
    }
}
