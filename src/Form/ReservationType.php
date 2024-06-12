<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        //today and 6 months after today
        $today = new \DateTime();
        $maxDate = (clone $today)->modify('+6 months');

        $builder
            ->add('firstname', TextType::class, [
                'label' => 'First name',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Your first name is required',
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Your first name must be at least {{ limit }} characters long',
                        'max' => 25,
                        'maxMessage' => 'Your first name cannot be longer than {{ limit }} characters',
                    ]),
                    new Regex([
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
            ->add('telephone', TelType::class, [
                'empty_data' => '',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Your telephone is required',
                    ]),
                    new Assert\Length([
                        'min' => 8,
                        'minMessage' => 'Your telephone must be at least {{ limit }} characters long.',
                        'max' => 25,
                        'maxMessage' => 'Your telephone cannot be longer than {{ limit }} characters.',
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
                'help' => 'Only numbers with or without + signal and no spaces',

            ])
            ->add('numberOfPeople', IntegerType::class, [
                'constraints' => [
                    new Assert\Range(['min' => 1, 'max' => 20]),
                    new Assert\NotBlank([
                        'message' => 'Number of people is required',
                    ]),
                    new Assert\Positive()
                ],
                'help' => '20 places maximum.',
                'attr' => [
                    'placeholder' => '10',
                    'minlength' => 1,
                    'maxlength' => 2,
                    'oninvalid' => "this.setCustomValidity('Please Enter valid number')",
                    'oninput' => "this.setCustomValidity(''); if (!this.checkValidity()) this.setCustomValidity('Please choose a number between 1 and 20');",
                ],
            ])
            ->add('reservationDate', DateType::class, [
                'help' => '6 months after today maximum.',
                'label' => 'Date',
                'format' => 'yyyy-MM-dd',
                'widget' => 'single_text',
                'attr' => [
                    'min' => $today->format('Y-m-d'), //  set minimum date to today
                    'max' => $maxDate->format('Y-m-d'), //max date 6 months later from today
                    'oninvalid' => "this.setCustomValidity('Please Enter valid date')",
                    'oninput' => "this.setCustomValidity(''); if (!this.checkValidity()) this.setCustomValidity('Please choose a valid date');",
                ],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Date is required']),
                ],
            ])

            ->add('reservationTime', TimeType::class, [
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Hour and minutes are required',
                    ]),
                ],
                'widget' => 'single_text',
                'widget' => 'choice',
                'hours' => range(20, 23),
                'minutes' => [0, 15, 30, 45],
                'label' => 'Hour:minutes',
                'required' => true,
                'help' => 'From 20:00 to 23:45',
                'placeholder' => [
                    'hour' => 'Hour',
                    'minute' => 'Minutes'
                ],
            ])
            ->add('comments', TextareaType::class, [
                'label' => 'Comments (optional)',
                'help' => '300 characters maximum.',
                'required' => false,
                'constraints' => [
                    new Assert\Length([
                        'min' => 15,
                        'minMessage' => 'Your comment must be at least {{ limit }} characters long',
                        'max' => 300,
                        'maxMessage' => 'Your comment cannot be longer than {{ limit }} characters',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^[0-9a-zA-ZÀ-ÿ\s?!.,:;()"\'\d]{15,300}$/',
                        'message' => 'Your comment can only contain letters.',
                    ])
                ],
                'attr' => [
                    'rows' => '10',
                    'minlength' => 15,
                    'maxlength' => 300,
                    'placeholder' => 'John',
                    'oninput' => "this.setCustomValidity(''); if (!this.checkValidity()) this.setCustomValidity('Your comment must be between 15 and 300 characters long.');",
                    'oninvalid' => "this.setCustomValidity('Please Enter valid comment. Minimum 15, and maximum 300 characters.')",
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}