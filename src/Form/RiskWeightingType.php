<?php

namespace App\Form;

use App\Entity\RiskWeighting;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RiskWeightingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('severityWeight', ChoiceType::class, [
                'label' => 'Gravité',
                'attr' => ['class' => 'form-control'],
                'choices' => [
                    'Pas de risque pour le client' => 1,
                    'Le produit peut être utilisé sous dérogation' => 5,
                    'Le produit ne peut être utilisé en l\'état' => 10,
                ],
            ])
            ->add('frequencyWeight', ChoiceType::class, [
                'label' => 'Fréquence',
                'attr' => ['class' => 'form-control'],
                'choices' => [
                    'Premiere apparition' => 2,
                    'Deuxiéme apparition' => 7,
                    'Répétitif' => 10,
                ],
            ])
            ->add('detectabilityWeight', ChoiceType::class, [
                'label' => 'Detectabilité (en interne)',
                'attr' => ['class' => 'form-control'],
                'choices' => [
                    'Probabilité forte de détecter le défaut' => 2,
                    'Probabilité moyenne de détecter le défaut' => 7,
                    'Probabilité faible de détecter le defaut' => 10,
                ],
            ])
            ->add('RiskPriorityIndex', TextType::class, [
                'label' => 'Indice de Priorité du Risque',
                'attr' => ['readonly' => true, 'class' => 'risk-priority-index form-control']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RiskWeighting::class,
        ]);
    }
}