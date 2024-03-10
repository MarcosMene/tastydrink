<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('firstname', TextType::class, [
            //     'disabled' => 'true',

            // ])
            // ->add('lastname', TextType::class, [
            //     'disabled' => 'true',

            // ])
            // ->add('email', EmailType::class, [
            //     'disabled' => true,
            // ])
            ->add('old_password', PasswordType::class, [
                'label' => 'Current password',
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Enter your current password'
                ]
            ])

            ->add('new_password', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'invalid_message' => 'The new passwords fields must match.',
                'required' => true,
                'label' => 'New password',
                'first_options'  => [
                    'label' => 'My new password',
                    'attr' => [
                        'placeholder' => 'Enter your new password'
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirm your new password',
                    'attr' => [
                        'placeholder' => 'New password'
                    ]
                ],

            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Update profile',
                'attr' => [
                    'class' => 'btn btn-primary btn-link my-4 mx-auto d-flex'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}