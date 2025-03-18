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

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

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
            ->add(
                'action',
                EntityType::class,
                array_merge(
                    [
                        'class' => ImmediateConservatoryMeasuresList::class,
                        'choice_label' => 'name',
                        'placeholder' => 'Choisissez une action :',
                        'label' => 'Actions Mises en Place',
                        'query_builder' => function (EntityRepository $er): QueryBuilder {
                            return $er->createQueryBuilder('t')
                                ->select('t')
                                ->where('t.archived IS NULL OR t.archived = false');
                        },
                    ],
                    $this->getDefaultOptions('Choisissez une action')
                )
            )
            ->add(
                'customAction',
                TextType::class,
                array_merge(
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
                )
            )
            ->add(
                'manager',
                TextType::class,
                array_merge(
                    [
                        'label' => 'Nom du Responsable',
                    ],
                    [
                        'required' => true,
                        'attr' => [
                            'class' => 'form-control mx-auto mt-2',
                            'placeholder' => 'Nom du Responsable'

                        ],
                        'label_attr' => [
                            'class' => 'form-label',
                            'style' => 'font-weight: bold; color: #ffffff;'
                        ],
                        'row_attr' => [
                            'class' => 'col-4 mb-3'
                        ],
                    ]
                )
            )
            ->add(
                'done',
                ChoiceType::class,
                array_merge(
                    [
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
                    [
                        'required' => true,
                        'attr' => [
                            'class' => 'form-control mx-auto mt-2',

                        ],
                        'label_attr' => [
                            'class' => 'form-label',
                            'style' => 'font-weight: bold; color: #ffffff;'
                        ],
                        'row_attr' => [
                            'class' => 'col-4 mb-3'
                        ],
                    ]
                )
            )
            ->add(
                'realisedAt',
                DateType::class,
                array_merge(
                    [
                        'label' => 'Date de réalisation',
                        'widget' => 'single_text',
                        'html5' => true,
                    ],
                    [
                        'required' => true,
                        'attr' => [
                            'class' => 'form-control mx-auto mt-2',

                        ],
                        'label_attr' => [
                            'class' => 'form-label',
                            'style' => 'font-weight: bold; color: #ffffff;'
                        ],
                        'row_attr' => [
                            'class' => 'col-4 mb-3'
                        ],
                    ]
                )
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ImmediateConservatoryMeasures::class,
        ]);
    }
}
