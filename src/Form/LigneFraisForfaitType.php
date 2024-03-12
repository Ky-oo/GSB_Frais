<?php

namespace App\Form;

use App\Entity\LigneFraisForfait;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LigneFraisForfaitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantiteKM', IntegerType::class, ["label" => 'Quantité Frais kilometrique',
                'attr' => ['class' => 'form-control']])
            ->add('quantiteEtape', IntegerType::class, ["label" => 'Quantité Frais étapes',
                'attr' => ['class' => 'form-control']])
            ->add('quantiteNuitee', IntegerType::class, ["label" => 'Quantité Frais nuité',
                'attr' => ['class' => 'form-control']])
            ->add('quantiteRepas', IntegerType::class, ["label" => 'Quantité Frais repas',
                'attr' => ['class' => 'form-control']])

            ->add('submit', SubmitType::class, ['attr' => ['class' => 'btn btn-primary mt-2']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
        ]);
    }
}
