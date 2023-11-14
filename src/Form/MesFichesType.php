<?php

namespace App\Form;

use App\Entity\FicheFrais;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MesFichesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('listMois', ChoiceType::class, ['choices' => $options['allFiches'],
                'choice_label'=> function(FicheFrais $ficheFrais) { String:
                    $mois = $ficheFrais->getMois();

                    $date = \DateTime::createFromFormat('F Y', $mois);
                    setlocale(LC_TIME, 'fr_FR');

                    // Obtenez le mois formaté en français
                    $moisEnFrancais = strftime('%B %Y', $date->getTimestamp());


                    return $ficheFrais->getMois();

            }]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'allFiches' => null,
        ]);
    }
}
