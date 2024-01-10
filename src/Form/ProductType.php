<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\ProductCategory;
use App\Entity\ProductColor;
use App\Entity\ProductVersion;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class ProductType extends AbstractType
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
                'class' => 'mb-3 col-4'
            ],
        ];
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('name')
            ->add(
                'category',
                EntityType::class,
                array_merge(
                    [
                        'label' => 'Type de Produit :',
                        'class' => ProductCategory::class,
                        'choice_label' => 'name',
                        'query_builder' => function (EntityRepository $er): QueryBuilder {
                            return $er->createQueryBuilder('t')
                                ->select('t')
                                ->where('t.archived IS NULL OR t.archived = false');
                        },
                    ],
                    $this->getDefaultOptions('Choisir un Type de Produits')
                )
            )
            ->add(
                'version',
                EntityType::class,
                array_merge(
                    [
                        'label' => 'Version de Produit :',
                        'class' => ProductVersion::class,
                        'choice_label' => 'name',
                        'query_builder' => function (EntityRepository $er): QueryBuilder {
                            return $er->createQueryBuilder('t')
                                ->select('t')
                                ->where('t.archived IS NULL OR t.archived = false');
                        },
                    ],
                    $this->getDefaultOptions('Choisir une Version de Produits')
                )
            )
            ->add(
                'color',
                EntityType::class,
                array_merge(
                    [
                        'label' => 'Couleur du produit :',
                        'class' => ProductColor::class,
                        'choice_label' => 'name',
                        'query_builder' => function (EntityRepository $er): QueryBuilder {
                            return $er->createQueryBuilder('t')
                                ->select('t')
                                ->where('t.archived IS NULL OR t.archived = false');
                        },
                    ],
                    $this->getDefaultOptions('Choisir une couleur de produit')
                )
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}