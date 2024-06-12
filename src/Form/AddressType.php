<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Regex;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Name of your address',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Your address name is required',
                    ]),
                    new Assert\Length([
                        'min' => 3,
                        'minMessage' => 'Your address name must be at least {{ limit }} characters long',
                        'max' => 25,
                        'maxMessage' => 'Your address name cannot be longer than {{ limit }} characters',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^[a-zA-ZÀ-ÿ\s\-]/',
                        'message' => 'Your address name can only contain letters.',
                    ])
                ],
                'attr' => [
                    'placeholder' => 'Ex. Home or office',
                    'minlength' => 3,
                    'maxlength' => 25,
                    'oninput' => "this.setCustomValidity(''); if (!this.checkValidity()) this.setCustomValidity('Your name address must be between 3 and 25 characters long and can only contain letters.');",
                    'oninvalid' => "this.setCustomValidity('Please Enter valid name address')",
                ]
            ])
            ->add('firstname', TextType::class, [
                'label' => 'First name',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Your first name is required',
                    ]),
                    new Assert\Length([
                        'min' => 3,
                        'minMessage' => 'Your first name must be at least {{ limit }} characters long',
                        'max' => 25,
                        'maxMessage' => 'Your first name cannot be longer than {{ limit }} characters',
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
            ->add('lastname', TextType::class, [
                'label' => 'Last name',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Your last name is required',
                    ]),
                    new Assert\Length([
                        'min' => 3,
                        'minMessage' => 'Your last name must be at least {{ limit }} characters long',
                        'max' => 25,
                        'maxMessage' => 'Your last name cannot be longer than {{ limit }} characters',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^[a-zA-ZÀ-ÿ\s]/',
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
            ->add('company', TextType::class, [
                'label' => "Company (optional)",
                'required' => false,
                'constraints' => [
                    new Assert\Length([
                        'min' => 3,
                        'minMessage' => 'Your company name must be at least {{ limit }} characters long',
                        'max' => 25,
                        'maxMessage' => 'Your company name cannot be longer than {{ limit }} characters',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^[a-zA-ZÀ-ÿ\s\-\0-9]/',
                        'message' => 'Your company name can only contain letters.',
                    ])
                ],
                'attr' => [
                    'minlength' => 3,
                    'maxlength' => 25,
                    'placeholder' => 'Company name'
                ],

            ])
            ->add('address', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Address is required',
                    ]),
                    new Assert\Length([
                        'min' => 10,
                        'minMessage' => 'Your address must be at least {{ limit }} characters long',
                        'max' => 60,
                        'maxMessage' => 'Your address cannot be longer than {{ limit }} characters',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^[a-zA-ZÀ-ÿ\s\-\0-9]/',
                        'message' => 'Your address can only contain letters and numbers.',
                    ])
                ],
                'attr' => [
                    'minlength' => 10,
                    'maxlength' => 60,
                    'placeholder' => 'Ex. 809 Grant McConachie ',
                    'oninput' => "this.setCustomValidity(''); if (!this.checkValidity()) this.setCustomValidity('Your address must be between 10 and 60 characters long and can only contain letters and numbers.');",
                    'oninvalid' => "this.setCustomValidity('Please Enter valid address')",
                ],

            ])
            ->add('postal', TextType::class,  [
                'label' => 'Postal code / ZIP Code',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'ZIP code is required.',
                    ]),
                    new Assert\Length([
                        'min' => 5,
                        'minMessage' => 'Your ZIP code must be at least {{ limit }} characters long.',
                        'max' => 10,
                        'maxMessage' => 'Your ZIP code cannot be longer than {{ limit }} characters.',
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9]{5,10}$/',
                        'message' => 'Your ZIP code can only contain letters and numbers.',
                    ]),
                ],
                'attr' => [
                    'placeholder' => '12345 ou MFDC2E',
                    'oninput' => "this.setCustomValidity(''); if (!this.checkValidity()) this.setCustomValidity('Your postal code must be between 5 and 10 characters long and can only contain letters.');",
                    'oninvalid' => "this.setCustomValidity('Please Enter valid postal code')",
                ]

            ])
            ->add('city', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Your city is required',
                    ]),
                    new Assert\Length([
                        'min' => 3,
                        'minMessage' => 'Your city must be at least {{ limit }} characters long',
                        'max' => 25,
                        'maxMessage' => 'Your city cannot be longer than {{ limit }} characters',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^[a-zA-ZÀ-ÿ\s\-]/',
                        'message' => 'Your city can only contain letters.',
                    ])
                ],
                'attr' => [
                    'minlength' => 3,
                    'maxlength' => 25,
                    'placeholder' => 'Ex. Montreal',
                    'oninput' => "this.setCustomValidity(''); if (!this.checkValidity()) this.setCustomValidity('Your city must be between 3 and 25 characters long and can only contain letters.');",
                    'oninvalid' => "this.setCustomValidity('Please Enter valid city')",
                ],
            ])
            ->add('country', CountryType::class, [
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Your country are required',
                    ]),
                ],
                'choice_loader' => new CallbackChoiceLoader(function () {
                    $countries = \Symfony\Component\Intl\Countries::getNames();
                    // Prepend "None" option
                    return ['None' => null] + $countries;
                }),
                'required' => true,
            ])
            ->add('phone', TelType::class, [
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Phone is required',
                    ]),
                    new Assert\Length([
                        'min' => 8,
                        'minMessage' => 'Your phone must be at least {{ limit }} characters long',
                        'max' => 25,
                        'maxMessage' => 'Your phone cannot be longer than {{ limit }} characters',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^[\+\(\s.\-\/\d\)]{5,30}$/',
                        'message' => 'The format of the telephone is not correct.',
                    ])
                ],
                'attr' => [
                    'minlength' => 8,
                    'maxlength' => 25,
                    'placeholder' => '+1601020304 or 0909090909',
                    'oninvalid' => "this.setCustomValidity('Please Enter valid telephone number')",
                    'oninput' => "this.setCustomValidity(''); if (!this.checkValidity()) this.setCustomValidity('Your telephone be between 8 and 25 characters long and can only contain letters.');",
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
