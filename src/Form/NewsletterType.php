<?php

namespace App\Form;

use App\Entity\Newsletter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewsletterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Enter your email',
                    'class' => 'form-control',
                    'style' => 'my-4',
                    'minlength' => 10,
                    'maxlength' => 50,
                    'oninput' => "this.setCustomValidity(''); if (!this.checkValidity()) this.setCustomValidity('Your email must be between 10 and 50 characters long and can only contain letters.');",
                    'oninvalid' => "this.setCustomValidity('Please Enter valid email')",
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Subscribe',
                'attr' => [
                    'class' => 'btn btn-primary btn-link mx-auto d-flex'
                ]
            ]);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Newsletter::class,
        ]);
    }
}
