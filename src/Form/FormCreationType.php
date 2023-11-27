<?php

namespace App\Form;

use App\Entity\AnomalyType;
use App\Entity\EFNC;
use App\Entity\Origin;
use App\Entity\Place;
use App\Entity\Project;
use App\Entity\Team;
use App\Entity\UAP;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use Symfony\Component\Validator\Constraints\File;

use Symfony\Component\OptionsResolver\OptionsResolver;

class FormCreationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Creator')
            ->add('DetectionDate', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'required' => true,
            ])
            ->add('DetectionTime', TimeType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'required' => true,
            ])
            ->add('Team', EntityType::class, [
                'class' => Team::class,
                'choice_label' => 'name',
                'required' => true,
            ])
            ->add('DetectionPlace', EntityType::class, [
                'class' => Place::class,
                'choice_label' => 'name',
                'required' => true,
            ])
            ->add('ProductDesignation')
            ->add('Project', EntityType::class, [
                'class' => Project::class,
                'choice_label' => 'name',
                'required' => true,
            ])
            ->add('UAP', EntityType::class, [
                'class' => UAP::class,
                'choice_label' => 'name',
                'required' => true,
            ])
            ->add('NonConformityOrigin', EntityType::class, [
                'class' => Origin::class,
                'choice_label' => 'name',
                'required' => true,
            ])
            ->add('AnomalyType', EntityType::class, [
                'class' => AnomalyType::class,
                'choice_label' => 'name',
                'required' => true,
            ])
            ->add('Quantity', NumberType::class, [
                'html5' => true,
                'required' => true,
                'input' => 'number',
                'attr' => ['min' => 0, 'max' => 1000000],
            ])
            ->add( 'QuantityToBlock', NumberType::class, [
            'html5' => true,
            'required' => true,
            'input' => 'number',
            'attr' => ['min' => 0, 'max' => 1000000],
        ]))
            ->add('DetailedDescription')
            ->add('SAPReference');


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