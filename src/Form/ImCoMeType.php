<?php

namespace App\Form;

use App\Entity\ImmediateConservatoryMeasures;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImCoMeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Action', ChoiceType::class, [
                'placeholder' => 'Choisissez une action',
                'label' => 'Actions Mises en Place',
                'choices' => [
                    'Alerter le manager de la zone ayant crée le problème'  => 'Alerter le manager de la zone ayant crée le problème',
                    'Alerter la ZIF et/ou le MAF'                           => 'Alerter la ZIF et/ou le MAF',
                    'Alerter PO FONTAINE et/ou PO GUICHEN'                  => 'Alerter PO FONTAINE et/ou PO GUICHEN',
                    'Réalisation d\'une Alerte d\'un problème'              => 'Réalisation d\'une Alerte d\'un problème',
                    'Compléter le formulaire de triage'                     => 'Compléter le formulaire de tri',
                    'Mise en place d\'un mode opératoire provisoire'        => 'Mise en place d\'un mode opératoire provisoire',
                    // Add a placeholder for other/custom action
                    'Autre (Précisez l\'action prise)'                      => 'other_option',
                ],
                'attr' => [
                    'class' => 'form-control',
                    'id' => 'action',
                    'required' => true
                ],
                'placeholder' => false, // Remove or set to null if a placeholder isn't needed
            ])
            ->add('CustomAction', TextType::class, [
                'mapped' => false, // Assuming this isn't directly mapped to a field in your entity
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Précisez l\'action prise',
                    'id' => 'custom_action',
                ],
            ])
            ->add('Manager', TextType::class, [
                'label' => 'Nom du Responsable',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nom du Responsable',
                    'id' => 'name',
                    'required' => true
                ]
            ])
            ->add('status', ChoiceType::class, [
                'placeholder' => 'L\'action est-elle réalisée ?',
                'label' => 'Fait ?',
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
                'multiple' => false,
                'expanded' => true,
                'required' => false,
                'placeholder' => false,
                'attr' => [
                    'class' => 'form-control'
                ],
                'choice_attr' => function ($choice) {
                    // Add disabled attribute to the third choice
                    if ($choice === 'Non') {
                        return ['class' => 'form-check-input', 'disabled' => 'disabled'];
                    }

                    return ['class' => 'form-check-input'];
                },
                // Define attributes for the label of each choice
                'label_attr' => ['class' => 'form-check-label'],
                // Enclose each radio button with a div that has Bootstrap classes
                'row_attr' => ['class' => 'form-check form-check-inline'],
            ])
            ->add('RealisedAt', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'required' => true,
            ])
            // ->add('EFNC')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ImmediateConservatoryMeasures::class,
        ]);
    }
}
