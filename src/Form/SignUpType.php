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
use Symfony\Component\Validator\Constraints as Assert;

class SignUpType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'First name',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Your first name is required.',
                    ]),
                    new Assert\Length([
                        'min' => 3,
                        'minMessage' => 'Your first name must be at least {{ limit }} characters long.',
                        'max' => 25,
                        'maxMessage' => 'Your first name cannot be longer than {{ limit }} characters.',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^[a-zA-ZÀ-ÿ\s\-]/',
                        'message' => 'Your first name can only contain letters.',
                    ])
                ],
                'attr' => [
                    'minlength' => 3,
                    'maxlength' => 25,
                    'placeholder' => 'John',
                    'oninput' => "this.setCustomValidity(''); if (!this.checkValidity()) this.setCustomValidity('Your first name must be between 3 and 25 characters long and can only contain letters.');",
                    'oninvalid' => "this.setCustomValidity('Please Enter valid first name')",
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Last name',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Your last name is required.',
                    ]),
                    new Assert\Length([
                        'min' => 3,
                        'minMessage' => 'Your last name must be at least {{ limit }} characters long.',
                        'max' => 25,
                        'maxMessage' => 'Your last name cannot be longer than {{ limit }} characters.',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^[a-zA-ZÀ-ÿ]/',
                        'message' => 'Your first name can only contain letters.',
                    ])
                ],
                'attr' => [
                    'minlength' => 3,
                    'maxlength' => 25,
                    'placeholder' => 'John',
                    'oninput' => "this.setCustomValidity(''); if (!this.checkValidity()) this.setCustomValidity('Your last name must be between 3 and 25 characters long and can only contain letters.');",
                    'oninvalid' => "this.setCustomValidity('Please Enter valid last name')",
                ]
            ])
            ->add('email', EmailType::class, [
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Your email is required.',
                    ]),
                    new Assert\Email([
                        'message' => 'The email is not a valid email.',
                    ]),
                    new Assert\Length([
                        'min' => 10,
                        'minMessage' => 'Your email must be at least {{ limit }} characters long.',
                        'max' => 50,
                        'maxMessage' => 'Your email cannot be longer than {{ limit }} characters.',
                    ]),
                ],
                'attr' => [
                    'minlength' => 10,
                    'maxlength' => 50,
                    'placeholder' => 'name@exemple.com',
                    'oninput' => "this.setCustomValidity(''); if (!this.checkValidity()) this.setCustomValidity('Your email must be between 10 and 50 characters long and can only contain letters.');",
                    'oninvalid' => "this.setCustomValidity('Please Enter valid email')",
                ],
            ])
            ->add('password', RepeatedType::class, [
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
                'invalid_message' => 'The password fields must match.',
                'required' => true,
                'first_options'  => [
                    'label' => 'Password',
                    'attr' => [
                        'placeholder' => 'Password',
                        'oninput' => "this.setCustomValidity(''); if (!this.checkValidity()) this.setCustomValidity('Your password must be between 6 and 16 characters long.');",
                        'oninvalid' => "this.setCustomValidity('Please Enter valid password')",
                    ]

                ],
                'second_options' => [
                    'label' => 'Confirm Password',
                    'attr' => [
                        'placeholder' => 'Enter your password again',
                        'oninput' => "this.setCustomValidity(''); if (!this.checkValidity()) this.setCustomValidity('The passwords must be the same.');",
                        'oninvalid' => "this.setCustomValidity('The passwords must be the same.')",
                    ]
                ],

            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Create',
                'attr' => [
                    'class' => 'btn btn-primary btn-link mt-5 mx-auto d-flex flex-column align-items-center'
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
