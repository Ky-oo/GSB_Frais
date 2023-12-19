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
            ->add('quantiteKM', IntegerType::class, ["label" => 'Quantité Frais kilometrique'])
            ->add('quantiteEtape', IntegerType::class, ["label" => 'Quantité Frais étapes'])
            ->add('quantiteNuitee', IntegerType::class, ["label" => 'Quantité Frais nuité'])
            ->add('quantiteRepas', IntegerType::class, ["label" => 'Quantité Frais repas'])
            ->add('submit', SubmitType::class )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
        ]);
    }
}
