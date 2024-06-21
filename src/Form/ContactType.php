<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'empty_data' => '',
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
                ],
            ])
            ->add('lastName', TextType::class, [
                'empty_data' => '',
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
                        'message' => 'Your last name can only contain letters.',
                    ])
                ],
                'attr' => [
                    'minlength' => 3,
                    'maxlength' => 25,
                    'placeholder' => 'Doe',
                    'oninput' => "this.setCustomValidity(''); if (!this.checkValidity()) this.setCustomValidity('Your last name must be between 3 and 25 characters long and can only contain letters.');",
                    'oninvalid' => "this.setCustomValidity('Please Enter valid last name')",
                ],
            ])
            ->add('email', EmailType::class, [
                'empty_data' => '',
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
            ->add('subject', TextType::class, [
                'empty_data' => '',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Your subject is required.',
                    ]),
                    new Assert\Length([
                        'min' => 10,
                        'minMessage' => 'Your subject must be at least {{ limit }} characters long.',
                        'max' => 100,
                        'maxMessage' => 'Your subject cannot be longer than {{ limit }} characters.',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^[a-zA-ZÀ-ÿ\s\-]/',
                        'message' => 'Your last name can only contain letters.',
                    ])
                ],
                'attr' => [
                    'minlength' => 10,
                    'maxlength' => 100,
                    'placeholder' => 'Subject title'
                ],
            ])
            ->add('message', TextareaType::class, [
                'empty_data' => '',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Your message is required.',
                    ]),
                    new Assert\Length([
                        'min' => 10,
                        'minMessage' => 'Your message must be at least {{ limit }} characters long.',
                        'max' => 300,
                        'maxMessage' => 'Your message cannot be longer than {{ limit }} characters.',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^[a-zA-ZÀ-ÿ\s\-0-9]/',
                        'message' => 'Your last name can only contain letters.',
                    ])
                ],
                'attr' => [
                    'minlength' => 10,
                    'maxlength' => 300,
                    'rows' => 5,
                    'placeholder' => 'Hi, Tasty Drink, I would like...'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
