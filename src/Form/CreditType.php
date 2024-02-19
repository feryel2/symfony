<?php

namespace App\Form;

use App\Entity\Credit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Type', ChoiceType::class, [
                'choices' => [
                    'Personal' => 'Personal',
                    'Home' => 'Home',
                    'Business' => 'Business',
                    'Car' => 'Car',
                ],
            ])
            ->add('MontantEmprunte')
            ->add('NbMois')
            ->add('DateEmission')
            ->add('Description')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Credit::class,
        ]);
    }
}
