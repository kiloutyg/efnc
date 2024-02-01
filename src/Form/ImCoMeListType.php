<?php

namespace App\Form;

use App\Entity\ImmediateConservatoryMeasuresList;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

class ImCoMeListType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom des Mesures Conservatrices Immediates',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nom des Mesures Conservatrices Immediates',
                    'id' => 'name',
                    'required' => true
                ]
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Ajouter',
                'attr' => [
                    'class' => 'btn btn-primary btn-login text-uppercase fw-bold mt-2 mb-3 submit-entity-creation',
                    'type' => 'submit'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ImmediateConservatoryMeasuresList::class,
        ]);
    }
}
