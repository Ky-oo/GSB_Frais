<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\FicheFrais;
use App\Entity\FraisForfait;
use App\Entity\LigneFraisForfait;
use App\Entity\LigneFraisHorsForfait;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class DataImportController extends AbstractController
{
    #[Route('/data/import', name: 'app_data_import')]
    public function index(ManagerRegistry $doctrine, UserPasswordHasherInterface $passwordHasher): Response
    {


        $userjson = file_get_contents('./lignefraishorsforfait.json');
        $fiches = json_decode($userjson, true);


        foreach ($fiches as $fiche){

            $makeFiche = new LigneFraisHorsForfait();

            $makeFiche->setLibelle($fiche["libelle"]);
            $dateTime = \DateTime::createFromFormat('Y-m-d', $fiche["date"]);
            $makeFiche->setDate($dateTime);
            $makeFiche->setMontant($fiche["montant"]);

            $user = $doctrine->getRepository(User::class)->findOneBy(["oldId" => $fiche["idVisiteur"]]);

            $mois = (\DateTime::createFromFormat('Ym', $fiche['mois']));
            $mois = $mois->format('F Y');

            $makeFiche->setFicheFrais($doctrine->getRepository(
                FicheFrais::class)->findOneBy(["mois" => $mois, "user" => $user]
            ));

            $doctrine->getManager()->persist($makeFiche);
            $doctrine->getManager()->flush();

        }

        return $this->render('data_import/index.html.twig', [
            'controller_name' => 'DataImportController',
        ]);
    }
}
