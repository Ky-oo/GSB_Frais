<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\FicheFrais; // Assurez-vous que cette ligne est correcte pour votre application
use App\Entity\LigneFraisForfait;
use App\Entity\LigneFraisHorsForfait;
use App\Form\LigneFraisForfaitType;
use App\Form\LigneFraisHorsForfaitType;
use App\Form\MesFichesType;
use App\Form\SaisieFicheType;
use App\Repository\FicheFraisRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Config\Doctrine\Orm\EntityManagerConfig;

class SaisieFicheController extends AbstractController
{
    #[Route('/saisie/fiche', name: 'app_saisie_fiche')]
    public function index(FicheFraisRepository $ficheFraisRepository, EntityManagerInterface $entityManager, Request $request): Response
    {

        $allFiches = $ficheFraisRepository->findAll();

        $dateActuel = new \DateTime('now');
        $moisEnCours = $dateActuel->format('Y-m');

        $actualFiche = null;

        foreach ($allFiches as $fiche) {
            if ($fiche->getMois() === $moisEnCours) {
                if ($actualFiche === null || $fiche->getDateModif() > $actualFiche->getDateModif()) {
                    $actualFiche = $fiche;
                    dd($actualFiche);
                }
            }
        }

        if ($actualFiche === null) {
            $actualFiche = new FicheFrais();
            $actualLigneForfait = new LigneFraisForfait();
            $actualLigneHorsForfait = new LigneFraisHorsForfait();
            $actualFiche->setMois($moisEnCours);
            $actualFiche->setEtat();
            $actualFiche->setUser($this->getUser())
            $actualLigneHorsForfait->setFicheFrais($actualFiche);

            $formForfait = $this->createForm(LigneFraisForfaitType::class);
            $formHorsForfait = $this->createForm(LigneFraisHorsForfaitType::class);

            if ($formForfait->isSubmitted() && $formForfait->isValid()) {
                $actualLigneForfait->setFicheFrais($actualFiche);
                dd($formForfait);


                $entityManager->persist($actualFiche);
                $entityManager->flush();
            }
        }

        return $this->render('saisie_fiche/index.html.twig', [
            'controller_name' => 'SaisieFicheController',
            'actualFiche' => $actualFiche,
            'formSaisie' => $formSaisie,
            'formForfait' => $formForfait,
            'formHorsForfait' => $formHorsForfait,
        ]);
    }
}
