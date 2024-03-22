<?php

namespace App\Form;

use Doctrine\ORM\Query\Expr\Select;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\User;
use function Sodium\add;

class AllUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('selectionner', ChoiceType::class, ['choices' => $options['allUser'],
                'choice_label'=> function(User $user) { String:
                    return $user->getNom() . " " . $user->getPrenom();
            },
                'attr' => ['class' => 'form-control dropdown-toggle']])

            ->add('Afficher', SubmitType::class, ['attr' => ['class' => 'btn btn-primary mt-2']]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'allUser' => null,
        ]);
    }
}
