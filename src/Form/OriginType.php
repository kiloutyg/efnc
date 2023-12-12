<?php

namespace App\Form;

use App\Entity\Origin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

class OriginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Appellation de l\'origine',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Appellation de l\'origine',
                    'id' => 'name',
                    'required' => true
                ]
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Ajouter',
                'attr' => [
                    'class' => 'btn btn-primary btn-login text-uppercase fw-bold mt-2 mb-3 submit-approval',
                    'type' => 'submit'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Origin::class,
        ]);
    }
}