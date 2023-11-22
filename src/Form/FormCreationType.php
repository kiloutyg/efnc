<?php

namespace App\Form;

use App\Entity\EFNC;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\StringType;

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
            ->add('Title')
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