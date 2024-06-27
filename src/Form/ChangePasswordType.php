<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('current_password', PasswordType::class, [
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Your password is required.',
                    ]),
                    new Assert\Length([
                        'min' => 6,
                        'minMessage' => 'Your password must be at least {{ limit }} characters long.',
                        'max' => 16,
                        'maxMessage' => 'Your password cannot be longer than {{ limit }} characters.',
                    ]),
                ],
                'label' => 'Current password',
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Enter your current password',
                    'minlength' => 6,
                    'maxlength' => 16,
                    'oninput' => "this.setCustomValidity(''); if (!this.checkValidity()) this.setCustomValidity('Your password must be between 6 and 16 characters long.');",
                    'oninvalid' => "this.setCustomValidity('Please Enter valid password')",
                ]
            ])

            ->add('new_password', RepeatedType::class, [
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Your password is required.',
                    ]),
                    new Assert\Length([
                        'min' => 6,
                        'minMessage' => 'Your password must be at least {{ limit }} characters long.',
                        'max' => 16,
                        'maxMessage' => 'Your password cannot be longer than {{ limit }} characters.',
                    ]),
                ],
                'type' => PasswordType::class,
                'mapped' => false,
                'invalid_message' => 'The new passwords fields must match.',
                'required' => true,
                'label' => 'New password',
                'first_options'  => [
                    'label' => 'My new password',
                    'attr' => [
                        'placeholder' => 'Enter your new password',
                        'minlength' => 6,
                        'maxlength' => 16,
                        'oninput' => "this.setCustomValidity(''); if (!this.checkValidity()) this.setCustomValidity('Your password must be between 6 and 16 characters long.');",
                        'oninvalid' => "this.setCustomValidity('Please Enter valid password')",
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirm your new password',
                    'attr' => [
                        'placeholder' => 'New password',
                        'minlength' => 6,
                        'maxlength' => 16,
                        'oninput' => "this.setCustomValidity(''); if (!this.checkValidity()) this.setCustomValidity('The passwords must be the same.');",
                        'oninvalid' => "this.setCustomValidity('The passwords must be the same.')",
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
            'data_class' => User::class,
        ]);
    }
}
