<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MonthType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('month', ChoiceType::class, [
                'choices' => [
                    'January' => 1,
                    'February' => 2,
                    'March' => 3,
                    'April' => 4,
                    'May' => 5,
                    'June' => 6,
                    'July' => 7,
                    'August' => 8,
                    'September' => 9,
                    'October' => 10,
                    'November' => 11,
                    'December' => 12,
                ],
                'attr' => ['class' => 'form-control']
            ])
            ->add('year', ChoiceType::class, [
                'choices' => array_combine(range(date('Y'), date('Y') - 10), range(date('Y'), date('Y') - 10)),
                'attr' => ['class' => 'form-control']
            ])
            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary mt-2']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}