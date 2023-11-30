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
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Creator', TextType::class, [
                'label' => 'Créateur :',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Prénom NOM',
                    'class' => 'form-control'
                ],
            ])
            ->add('DetectionDate', DateType::class, [
                'label' => 'Date de Détection :',
                'widget' => 'single_text',
                'html5' => true,
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('DetectionTime', TimeType::class, [
                'label' => 'Heure de Détection :',
                'widget' => 'single_text',
                'html5' => true,
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('Team', EntityType::class, [
                // 'placeholder' => 'Choisir une équipe :',
                'label' => 'Equipe :',
                'class' => Team::class,
                'choice_label' => 'name',
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('DetectionPlace', EntityType::class, [
                // 'placeholder' => 'Choisir le lieu de détection de la Non-Conformité :',
                'label' => 'Lieu de détection :',
                'class' => Place::class,
                'choice_label' => 'name',
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('ProductDesignation', TextType::class, [
                'label' => 'Désignation du Produit :',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Référence, Désignation, ...',

                    'class' => 'form-control'
                ],
            ])
            ->add('Project', EntityType::class, [
                // 'placeholder' => 'Choisir le projet :',
                'label' => 'Projet :',
                'class' => Project::class,
                'choice_label' => 'name',
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('UAP', EntityType::class, [
                // 'placeholder' => 'Choisir l\'UAP :',
                'label' => 'UAP :',
                'class' => UAP::class,
                'choice_label' => 'name',
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('NonConformityOrigin', EntityType::class, [
                // 'placeholder' => 'Choisir le lieu de création de la Non-Conformité :',
                'label' => 'Lieu de création de la Non-Conformité :',
                'class' => Origin::class,
                'choice_label' => 'name',
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('AnomalyType', EntityType::class, [
                // 'placeholder' => 'Choisir le type de Non-Conformité :',
                'label' => 'Type de d\'anomalie :',
                'class' => AnomalyType::class,
                'choice_label' => 'name',
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('Quantity', NumberType::class, [
                'label' => 'Nombre de Pièces Non-Conforme :',
                'html5' => true,
                'required' => true,
                'input' => 'number',
                'attr' => [
                    'min' => 0, 'max' => 1000000,
                    'class' => 'form-control',
                    'placeholder' => '00',

                ],
            ])
            ->add('QuantityToBlock', NumberType::class, [
                'label' => 'Nombre de pièces à bloquer :',
                'html5' => true,
                'required' => true,
                'input' => 'number',
                'attr' => [
                    'min' => 0, 'max' => 1000000,
                    'class' => 'form-control',
                    'placeholder' => '00',

                ],
            ])
            ->add('DetailedDescription', TextareaType::class, [
                'label' => 'Description détaillée :',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Description détaillée de la non-conformité',
                ],
            ])
            ->add('SAPReference', TextType::class, [

                'label' => 'Référence SAP :',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Référence => XXXXXXXX',

                    'class' => 'form-control'
                ],
            ])
            ->add('immediateConservatoryMeasures', CollectionType::class, [
                'label' => 'Mesures Conservatoires Immédiates :',
                'entry_type' => ImCoMeType::class,
                'allow_add'    => true,
                'by_reference' => false,
                'attr' => ['class' => 'form-control row ']
                // 'allow_delete' => true, if you want to allow removing items from the collection
            ]);


        // Add an event listener for the form
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                $form = $event->getForm();
                $efnc = $event->getData();

                // Check if EFNC is null (when creating a new form)
                if (!$efnc || null === $efnc->getId()) {
                    return;
                }

                // if ($efnc->getStatus()) {
                //     // Make PilotVisa required if Status is true
                //     $form->add('PilotVisa', null, ['required' => true]);
                // }
            }
        );
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EFNC::class,
        ]);
    }
}