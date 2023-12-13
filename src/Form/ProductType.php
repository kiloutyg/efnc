<?php

namespace App\Form;

use App\Entity\EFNC;
use App\Entity\Product;
use App\Entity\ProductCategory;
use App\Entity\ProductColor;
use App\Entity\ProductVersion;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('EFNC', EntityType::class, [
                'class' => EFNC::class,
'choice_label' => 'id',
            ])
            ->add('category', EntityType::class, [
                'class' => ProductCategory::class,
'choice_label' => 'id',
            ])
            ->add('version', EntityType::class, [
                'class' => ProductVersion::class,
'choice_label' => 'id',
            ])
            ->add('color', EntityType::class, [
                'class' => ProductColor::class,
'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
