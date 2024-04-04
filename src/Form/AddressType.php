<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Name of your address',
                'attr' => [
                    'placeholder' => 'Ex. Home or office'
                ]
            ])
            ->add('firstname', TextType::class, [
                'label' => 'First name',
                'attr' => [
                    'placeholder' => 'John'
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Last name',
                'attr' => [
                    'placeholder' => 'Doe'
                ]
            ])
            ->add('company', TextType::class, [
                'label' => "Company (optional)",
                'required' => false,
                'attr' => [
                    'placeholder' => 'Company name'
                ]
            ])
            ->add('address', TextType::class, [
                'attr' => [
                    'placeholder' => 'Ex. 809 Grant McConachie '
                ]
            ])
            ->add('postal', TextType::class,  [
                'label' => 'Postal code / ZIP Code',
                'attr' => ['placeholder' => '12345']

            ])
            ->add('city', TextType::class, [
                'attr' => ['placeholder' => 'Ex. Montreal']
            ])
            ->add('country', CountryType::class, [
                'attr' => [
                    'placeholder' => 'Country',
                ]
            ])
            ->add('phone', TelType::class, [
                'attr' => [
                    'placeholder' => '0909099900'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
