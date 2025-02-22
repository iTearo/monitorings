<?php

declare(strict_types=1);

namespace App\Form;

use Domain\File\Domain\MimeType;
use Domain\Outlet\Domain\CommercialNetwork;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class CommercialNetworkFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')

            ->add('logotype', FileType::class, [
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => MimeType::ALLOWED_MIME_TYPES,
                    ])
                ],
            ])

            ->add('save', SubmitType::class, [
                'translation_domain' => 'form'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CommercialNetwork::class,
            'name' => 'form',
            'translation_domain' => 'commercial_network'
        ]);
    }
}
