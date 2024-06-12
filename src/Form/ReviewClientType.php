<?php

namespace App\Form;

use App\Entity\ReviewClient;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;

class ReviewClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'empty_data' => '',
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
                ],
            ])
            ->add('rate', ChoiceType::class, [
                'label' => 'Your rating',
                'choices' => [
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5
                ],
                'attr' => [
                    'class' => 'd-flex m-0 p-0'
                ],
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'Your opinion',
                'help' => '200 characters maximum.',
                'constraints' => [
                    new Assert\Length([
                        'min' => 15,
                        'minMessage' => 'Your comment must be at least {{ limit }} characters long',
                        'max' => 200,
                        'maxMessage' => 'Your comment cannot be longer than {{ limit }} characters',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^[0-9a-zA-ZÀ-ÿ\s?!.,:;()"\'\d]{15,200}$/',
                        'message' => 'Your comment can only contain letters.',
                    ])
                ],
                'attr' => [
                    'rows' => '5',
                    'minlength' => 15,
                    'maxlength' => 200,
                    'placeholder' => 'John',
                    'oninput' => "this.setCustomValidity(''); if (!this.checkValidity()) this.setCustomValidity('Your comment must be between 15 and 200 characters long.');",
                    'oninvalid' => "this.setCustomValidity('Please Enter valid comment. Minimum 15, and maximum 200 characters.')",
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Send',
                'attr' => [
                    'class' => 'btn btn-primary btn-link mt-5 mx-auto d-flex flex-column align-items-center w-100'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ReviewClient::class,
        ]);
    }
}
