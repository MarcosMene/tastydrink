<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\Carrier;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            //entitytype to find address from database
            ->add('addresses', EntityType::class, [
                'label' => 'Delivery address',
                'attr' => [
                    'class' => ' my-3 text-capitalize'
                ],
                'required' => true,
                'class' => Address::class,
                'expanded' => true, //separate input dropdown in checkbox
                'choices' => $options['addresses'],
                'label_html' => true //to_String with html code
            ])
            ->add('carriers', EntityType::class, [
                'label' => 'Carrier delivery company',
                'attr' => [
                    'class' => ' my-3 text-capitalize'
                ],
                'required' => true,
                'class' => Carrier::class,
                'expanded' => true, //separate input dropdown in checkbox
                'label_html' => true //to_String with html code
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Confirm order',
                'attr' => [
                    'class' => 'btn btn-link mt-5 mx-auto d-flex text-uppercase'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'addresses' => null //to make it required we set the default
        ]);
    }
}
