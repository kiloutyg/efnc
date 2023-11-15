<?php

namespace App\Form;

use App\Entity\EFNC;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormCreationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Title')
            ->add('Creator')
            ->add('DetectionDate')
            ->add('Team')
            ->add('DetectionPlace')
            ->add('ProductDesignation')
            ->add('Project')
            ->add('UAP')
            ->add('NonConformityOrigin')
            ->add('Quantity')
            ->add('AnomalyType')
            ->add('QuantityToBlock')
            ->add('DetailedDescription')
            ->add('CreatedAt')
            ->add('UpdatedAt')
            ->add('SAPReference')
            ->add('Status')
            ->add('ClosedDate')
            ->add('PilotVisa')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EFNC::class,
        ]);
    }
}
