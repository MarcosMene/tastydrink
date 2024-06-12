<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;


class ForgotPasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
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
                'label' => 'Your email address',
                'attr' => [
                    'minlength' => 10,
                    'maxlength' => 50,
                    'placeholder' => 'name@exemple.com',
                    'oninput' => "this.setCustomValidity(''); if (!this.checkValidity()) this.setCustomValidity('Your email must be between 10 and 50 characters long and can only contain letters.');",
                    'oninvalid' => "this.setCustomValidity('Please Enter valid email')",
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Reset Password',
                'attr' => [
                    'class' => 'btn btn-primary btn-link mt-5 mx-auto d-flex'
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