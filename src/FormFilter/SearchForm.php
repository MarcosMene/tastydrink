<?php

namespace App\FormFilter;

use App\Data\SearchData;
use App\Entity\Category;
use App\Entity\ColorProduct;
use App\Entity\CountryProduct;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchForm extends AbstractType
{

  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('q', TextType::class, [
        'label' => false,
        'required' => false,
        'attr' => [
          'placeholder' => 'Find a product'
        ]
      ])

      ->add('categories', EntityType::class, [
        'label' => false,
        'required' => false,
        'class' => Category::class,
        'expanded' => true,
        'multiple' => true
      ])
      ->add('country', EntityType::class, [
        'label' => false,
        'required' => false,
        'class' => CountryProduct::class,
        'expanded' => true,
        'multiple' => true
      ])
      ->add('color', EntityType::class, [
        'label' => false,
        'required' => false,
        'class' => ColorProduct::class,
        'expanded' => true,
        'multiple' => true
      ])
      ->add('min', NumberType::class, [
        'label' => false,
        'required' => false,
        'attr' => [
          'placeholder' => "Min price",
        ]
      ])
      ->add('max', NumberType::class, [
        'label' => false,
        'required' => false,
        'attr' => [
          'placeholder' => "Max price",
        ]
      ]);
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class' => SearchData::class,
      'method' => 'GET',
      'csrf_protection' => false
    ]);
  }

  public function getBlockPrefix()
  {
    return ''; // No block prefix needed!
  }
}
