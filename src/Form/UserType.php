<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', null, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('password', null, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('nom', null, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('prenom', null, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('adresse', null, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('cp', null, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('ville', null, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('dateEmbauche', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
