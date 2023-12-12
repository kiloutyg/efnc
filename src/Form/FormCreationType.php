<?php

namespace App\Form;

use App\Entity\AnomalyType;
use App\Entity\EFNC;
use App\Entity\Origin;
use App\Entity\Place;
use App\Entity\Project;
use App\Entity\Team;
use App\Entity\UAP;

use App\Form\ImCoMeType;

use Symfony\Component\Form\AbstractType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;


use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use Symfony\Component\OptionsResolver\OptionsResolver;

class FormCreationType extends AbstractType
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
                'Creator',
                TextType::class,
                array_merge(
                    [
                        'label' => 'Créateur :',
                    ],
                    $this->getDefaultOptions('Prénom NOM')
                )
            )
            ->add(
                'DetectionDate',
                DateType::class,
                array_merge(
                    [
                        'label' => 'Date de Détection :',
                        'widget' => 'single_text',
                        'html5' => true,
                    ],
                    $this->getDefaultOptions('')
                )
            )
            ->add(
                'DetectionTime',
                TimeType::class,
                array_merge(
                    [
                        'label' => 'Heure de Détection :',
                        'widget' => 'single_text',
                        'html5' => true,
                    ],
                    $this->getDefaultOptions('')
                )
            )
            ->add(
                'Team',
                EntityType::class,
                array_merge(
                    [
                        'label' => 'Equipe :',
                        'class' => Team::class,
                        'choice_label' => 'name',
                    ],
                    $this->getDefaultOptions('Choisir une équipe :')
                )
            )
            ->add(
                'DetectionPlace',
                EntityType::class,
                array_merge(
                    [
                        'label' => 'Lieu de détection :',
                        'class' => Place::class,
                        'choice_label' => 'name',
                    ],
                    $this->getDefaultOptions('Choisir le lieu de détection de la Non-Conformité :')
                )
            )
            ->add(
                'ProductDesignation',
                TextType::class,
                array_merge(
                    [
                        'label' => 'Désignation du Produit :',
                    ],
                    $this->getDefaultOptions('Référence, Désignation, ...')
                )
            )
            ->add(
                'Project',
                EntityType::class,
                array_merge(
                    [
                        'label' => 'Projet :',
                        'class' => Project::class,
                        'choice_label' => 'name',
                    ],
                    $this->getDefaultOptions('Choisir le projet :')
                )
            )
            ->add(
                'UAP',
                EntityType::class,
                array_merge(
                    [
                        'label' => 'UAP :',
                        'class' => UAP::class,
                        'choice_label' => 'name',
                    ],
                    $this->getDefaultOptions('Choisir l\'UAP :')
                )
            )
            ->add(
                'NonConformityOrigin',
                EntityType::class,
                array_merge(
                    [
                        'label' => 'Lieu de création de la Non-Conformité :',
                        'class' => Origin::class,
                        'choice_label' => 'name'
                    ],
                    $this->getDefaultOptions('Choisir le lieu de création de la Non-Conformité :')
                )
            )
            ->add(
                'AnomalyType',
                EntityType::class,
                array_merge(
                    [
                        'label' => 'Type de d\'anomalie :',
                        'class' => AnomalyType::class,
                        'choice_label' => 'name',
                    ],
                    $this->getDefaultOptions('Choisir le type de Non-Conformité :')
                )
            )
            ->add(
                'Quantity',
                NumberType::class,
                array_merge(
                    [
                        'label' => 'Nombre de Pièces Non-Conforme :',
                        'html5' => true,
                        'input' => 'number',
                        'attr' => [
                            'min' => 0, 'max' => 1000000,
                        ],
                    ],
                    $this->getDefaultOptions('00')
                )
            )
            ->add(
                'QuantityToBlock',
                NumberType::class,
                array_merge(
                    [
                        'label' => 'Nombre de pièces à bloquer :',
                        'html5' => true,
                        'input' => 'number',
                        'attr' => [
                            'min' => 0, 'max' => 1000000,
                        ],
                    ],
                    $this->getDefaultOptions('00')
                )
            )
            ->add(
                'DetailedDescription',
                TextareaType::class,
                array_merge(
                    [
                        'label' => 'Description détaillée :',
                    ],
                    $this->getDefaultOptions('Description détaillée de la non-conformité')
                )
            )
            ->add(
                'SAPReference',
                TextType::class,
                array_merge(
                    [
                        'required' => false,
                        'label' => 'Référence SAP :',
                        'attr' => [
                            'class' => 'form-control mx-auto mt-2',
                            'placeholder' => 'Référence => XXXXXXXX'
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
            ->add('immediateConservatoryMeasures', CollectionType::class, array_merge(
                [
                    'label' => 'Mesures Conservatoires Immédiates :',
                    'entry_type' => ImCoMeType::class,
                    'allow_add'    => true,
                    'by_reference' => false,
                    // 'allow_delete' => true, if you want to allow removing items from the collection

                ],
                $this->getDefaultOptions('')
            ))
            ->add('riskWeighting', RiskWeightingType::class, array_merge(
                [
                    'label' => 'Pondération des risques:',
                ],
                $this->getDefaultOptions('')
            ));
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EFNC::class,
        ]);
    }
}