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
    private function getDefaultOptions($placeholder = '')
    {
        return [
            'required' => true,
            'attr' => [
                'class' => 'form-control mx-auto mt-2',
                'placeholder' => $placeholder
            ],
            'label_attr' => [
                'class' => 'form-label',
                'style' => 'font-weight: bold; color: #ffffff;'
            ],
            'row_attr' => [
                'class' => 'mb-3'
            ],
        ];
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('action', EntityType::class, array_merge(
                [
                    'class' => ImmediateConservatoryMeasuresList::class,
                    'choice_label' => 'name',
                    'label' => 'Actions Mises en Place',
                ],
                $this->getDefaultOptions('Choisissez une action')
            ))
            ->add('customAction', TextType::class, array_merge(
                [
                    'required' => false,
                    'label' => 'Autre Action',
                    'attr' => [
                        'class' => 'form-control mx-auto mt-2',
                        'placeholder' => 'Précisez l\'action prise'
                    ],
                    'label_attr' => [
                        'class' => 'form-label',
                        'style' => 'font-weight: bold; color: #ffffff;'
                    ],
                    'row_attr' => [
                        'class' => 'mb-3'
                    ],
                ]
            ))
            ->add('Manager', TextType::class, array_merge(
                [
                    'label' => 'Nom du Responsable',
                ],
                $this->getDefaultOptions('Nom du Responsable')
            ))
            ->add('status', ChoiceType::class, array_merge(
                [
                    'placeholder' => 'L\'action est-elle réalisée ?',
                    'label' => 'Fait ?',
                    'choices' => [
                        'Oui' => true,
                        'Non' => false,
                    ],
                    'multiple' => false,
                    'placeholder' => false,
                    'choice_attr' => function ($choice) {
                        // Add disabled attribute to the third choice
                        if ($choice === 'Non') {
                            return ['class' => 'form-check-input col-auto', 'disabled' => 'disabled'];
                        }
                        return ['class' => 'form-check-input col-auto'];
                    },
                ],
                $this->getDefaultOptions('')
            ))
            ->add('RealisedAt', DateType::class, array_merge(
                [
                    'widget' => 'single_text',
                    'html5' => true,
                ],
                $this->getDefaultOptions('')
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ImmediateConservatoryMeasures::class,
        ]);
    }
}