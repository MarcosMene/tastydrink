<?php

namespace App\Form;

use App\Entity\Review;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
                'attr' => [
                    'rows' => 3
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
