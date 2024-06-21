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

class ResetPasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
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
                'label' => 'New password',
                'first_options'  => [
                    'label' => 'Your new password',
                    'attr' => [
                        'placeholder' => 'Enter your new password',
                        'oninput' => "this.setCustomValidity(''); if (!this.checkValidity()) this.setCustomValidity('Your password must be between 6 and 16 characters long.');",
                        'oninvalid' => "this.setCustomValidity('Please Enter valid password')",
                    ],
                    'hash_property_path' => 'password'
                ],
                'second_options' => [
                    'label' => 'Confirm your new password',
                    'attr' => [
                        'placeholder' => 'New password',
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
            'data_class' => User::class
        ]);
    }
}
