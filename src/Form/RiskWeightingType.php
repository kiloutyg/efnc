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
                'class' => 'col-4 mb-3'
            ],
        ];
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('severityWeight', ChoiceType::class, array_merge(
                [
                    'label' => 'Gravité',
                    'choices' => [
                        'Pas de risque pour le client' => 1,
                        'Le produit peut être utilisé sous dérogation' => 5,
                        'Le produit ne peut être utilisé en l\'état' => 10,
                    ],
                ],
                $this->getDefaultOptions('Choisissez une Gravité')
            ))
            ->add('frequencyWeight', ChoiceType::class, array_merge(
                [
                    'label' => 'Fréquence',
                    'choices' => [
                        'Premiere apparition' => 2,
                        'Deuxiéme apparition' => 7,
                        'Répétitif' => 10,
                    ],
                ],
                $this->getDefaultOptions('Choisissez une Fréquence')
            ))
            ->add('detectabilityWeight', ChoiceType::class, array_merge(
                [
                    'label' => 'Detectabilité (en interne)',
                    'choices' => [
                        'Probabilité forte de détecter le défaut' => 2,
                        'Probabilité moyenne de détecter le défaut' => 7,
                        'Probabilité faible de détecter le defaut' => 10,
                    ],
                ],
                $this->getDefaultOptions('Choisissez une Detectabilité (en interne)')
            ))
            ->add('RiskPriorityIndex', TextType::class, array_merge(
                [
                    'label' => 'Indice de Priorité du Risque',
                    'attr' => ['readonly' => true, 'class' => 'risk-priority-index']
                ],
                $this->getDefaultOptions('Choisissez une action')
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RiskWeighting::class,
        ]);
    }
}