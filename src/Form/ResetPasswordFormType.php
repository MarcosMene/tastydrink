<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResetPasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('new_password', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'invalid_message' => 'The new passwords fields must match.',
                'label' => 'New password',
                'first_options'  => [
                    'label' => 'Your new password',
                    'attr' => [
                        'placeholder' => 'Enter your new password'
                    ],
                    'hash_property_path' => 'password'
                ],
                'second_options' => [
                    'label' => 'Confirm your new password',
                    'attr' => [
                        'placeholder' => 'New password'
                    ]
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Update password',
                'attr' => [
                    'class' => 'btn btn-primary btn-link mt-5 mx-auto d-flex'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }
}
