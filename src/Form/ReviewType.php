<?php

namespace App\Form;

use App\Entity\Review;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;

class ReviewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
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
            ->add('review', TextareaType::class, [
                'label' => 'Your review',
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
                    'rows' => 3,
                    'minlength' => 15,
                    'maxlength' => 300,
                    'placeholder' => 'John',
                    'oninput' => "this.setCustomValidity(''); if (!this.checkValidity()) this.setCustomValidity('Your comment must be between 15 and 300 characters long.');",
                    'oninvalid' => "this.setCustomValidity('Please Enter valid comment. Minimum 15, and maximum 300 characters.')",
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Review',
                'attr' => [
                    'class' => 'btn btn-outline-primary btn-signOut mt-5 mx-auto d-flex text-dark bg-white'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Review::class,
        ]);
    }
}
