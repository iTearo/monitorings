<?php

declare(strict_types=1);

namespace App\Form;

use Domain\Outlet\Domain\CommercialNetwork;
use Domain\Outlet\Domain\CommercialNetworkRepository;
use Domain\Outlet\Domain\Outlet;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OutletFormType extends AbstractType
{
    private CommercialNetworkRepository $commercialNetworkRepository;

    public function __construct(
        CommercialNetworkRepository $commercialNetworkRepository
    ) {
        $this->commercialNetworkRepository = $commercialNetworkRepository;
    }

    /**
     * @return CommercialNetwork[]
     */
    protected function getCommercialNetworks(): array
    {
        $commercialNetworks = $this->commercialNetworkRepository->getAll();

        usort(
            $commercialNetworks,
            fn(CommercialNetwork $commercialNetwork1, CommercialNetwork $commercialNetwork2)
            => $commercialNetwork1->getTitle() <=> $commercialNetwork2->getTitle()
        );

        return $commercialNetworks;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('commercialNetwork', EntityType::class, [
                'class' => CommercialNetwork::class,
                'choices' => $this->getCommercialNetworks(),
                'choice_value' => 'id',
                'choice_label' => 'title',
                'choice_attr' => static function($choice, $key, $value) {
                    return ['data-select2-id' => $value];
                },
                'attr' => ['class' => 'select2'],
            ])

            ->add('address', AddressFormType::class)

            ->add('save', SubmitType::class, [
                'translation_domain' => 'form'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Outlet::class,
            'name' => 'form',
            'translation_domain' => 'outlet'
        ]);
    }
}
