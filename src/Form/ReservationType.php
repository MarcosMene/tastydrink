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
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        //today and 6 months after today
        $today = new \DateTime();
        $maxDate = (clone $today)->modify('+6 months');

        $builder
            ->add('firstname', TextType::class, [
                'attr' => [
                    'placeholder' => 'John'
                ],
                'required' => true,
            ])
            ->add('lastname', TextType::class, [
                'attr' => [
                    'placeholder' => 'Doe'
                ],
            ])
            ->add('telephone', TelType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => '+1601020304 or 0909090909'
                ],
                'help' => 'Only numbers with or without + signal and no spaces',
            ])
            ->add('numberOfPeople', IntegerType::class, [
                'help' => '20 places maximum.',
                'attr' => [
                    'placeholder' => '10'
                ],
                'constraints' => [
                    new Range(['min' => 1, 'max' => 20]),
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
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Date is required']),
                ],
            ])

            ->add('reservationTime', TimeType::class, [
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
                'help' => '300 characters maximum.',
                'attr' => ['rows' => '10'],
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
