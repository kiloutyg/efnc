<?php

namespace App\Form;

use App\Entity\ImmediateConservatoryMeasures;
use App\Entity\ImmediateConservatoryMeasuresList;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

use Symfony\Component\OptionsResolver\OptionsResolver;

class ImCoMeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('action', EntityType::class, [
                'class' => ImmediateConservatoryMeasuresList::class,
                // 'placeholder' => 'Choisissez une action',
                'choice_label' => 'name',
                'label' => 'Actions Mises en Place',
                'attr' => [
                    'class' => 'form-control col-auto',
                    'id' => 'action',
                ],
                'placeholder' => false, // Remove or set to null if a placeholder isn't needed
            ])
            ->add('customAction', TextType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'form-control col-auto',
                    'placeholder' => 'Précisez l\'action prise',
                    'id' => 'custom_action',
                ],
            ])
            ->add('Manager', TextType::class, [
                'label' => 'Nom du Responsable',
                'attr' => [
                    'class' => 'form-control col-auto',
                    'placeholder' => 'Nom du Responsable',
                    'id' => 'name',

                ],
                'required' => true
            ])
            ->add('status', ChoiceType::class, [
                'placeholder' => 'L\'action est-elle réalisée ?',
                'label' => 'Fait ?',
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
                'multiple' => false,
                'placeholder' => false,
                'attr' => [
                    'class' => 'form-control col-auto'
                ],
                'choice_attr' => function ($choice) {
                    // Add disabled attribute to the third choice
                    if ($choice === 'Non') {
                        return ['class' => 'form-check-input col-auto', 'disabled' => 'disabled'];
                    }
                    return ['class' => 'form-check-input col-auto'];
                },
                // Define attributes for the label of each choice
                'label_attr' => ['class' => 'form-check-label col-auto'],
                // Enclose each radio button with a div that has Bootstrap classes
                'row_attr' => ['class' => 'form-check form-check-inline col-auto'],
            ])
            ->add('RealisedAt', DateType::class, [
                'attr' => [
                    'class' => 'form-control col-auto'
                ],
                'widget' => 'single_text',
                'html5' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ImmediateConservatoryMeasures::class,
        ]);
    }
}