<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\FicheFrais; // Assurez-vous que cette ligne est correcte pour votre application
use App\Entity\LigneFraisForfait;
use App\Entity\LigneFraisHorsForfait;
use App\Form\LigneFraisForfaitType;
use App\Form\LigneFraisHorsForfaitType;
use App\Repository\EtatRepository;
use App\Repository\FicheFraisRepository;
use App\Repository\FraisForfaitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SaisieFicheController extends AbstractController
{
    #[Route('/saisie/fiche', name: 'app_saisie_fiche')]
    public function index(
        FicheFraisRepository $ficheFraisRepository,
        EntityManagerInterface $entityManager,
        Request $request,
        EtatRepository $etatRepository,
        FraisForfaitRepository $forfaitRepository
    ): Response
    {

        $dateActuel = new \DateTime('now');
        $moisEnCours = $dateActuel->format('F Y');
        $ficheMoisUser = $ficheFraisRepository->findOneBy(['user'=>$this->getUser(), 'mois'=>$moisEnCours]);

        $actualLigneHorsForfait = new LigneFraisHorsForfait();

        $formForfait = $this->createForm(LigneFraisForfaitType::class);
        $formHorsForfait = $this->createForm(LigneFraisHorsForfaitType::class, $actualLigneHorsForfait);
        $formForfait->handleRequest($request);
        $formHorsForfait->handleRequest($request);

        if ($ficheMoisUser === null) {
            $actualFiche = new FicheFrais();
            $actualLigneForfaitKM = new LigneFraisForfait();
            $actualLigneForfaitEtape = new LigneFraisForfait();
            $actualLigneForfaitNuitee = new LigneFraisForfait();
            $actualLigneForfaitRepas = new LigneFraisForfait();

            $actualLigneForfaitKM->setFicheFrais($actualFiche);
            $actualLigneForfaitEtape->setFicheFrais($actualFiche);
            $actualLigneForfaitNuitee->setFicheFrais($actualFiche);
            $actualLigneForfaitRepas->setFicheFrais($actualFiche);

            $actualLigneForfaitRepas->setQuantite(0);
            $actualLigneForfaitKM->setQuantite(0);
            $actualLigneForfaitNuitee->setQuantite(0);
            $actualLigneForfaitEtape->setQuantite(0);

            $actualLigneForfaitKM->setFraisForfait($forfaitRepository->findOneBy(['id' => 1]));
            $actualLigneForfaitEtape->setFraisForfait($forfaitRepository->findOneBy(['id' => 2]));
            $actualLigneForfaitNuitee->setFraisForfait($forfaitRepository->findOneBy(['id' => 3]));
            $actualLigneForfaitRepas->setFraisForfait($forfaitRepository->findOneBy(['id' => 4]));

            $actualFiche->setMois($moisEnCours);
            $actualFiche->setEtat($etatRepository->findOneBy(['id' => 1]));
            $actualFiche->setUser($this->getUser());
            $actualFiche->setNbJustificatifs(0);

            $actualFiche->setMontantValid(0);
            $actualLigneHorsForfait->setFicheFrais($actualFiche);
            $actualFiche->setDateModif(new \DateTime('now'));

            $entityManager->persist($actualFiche);
            $entityManager->persist($actualLigneForfaitRepas);
            $entityManager->persist($actualLigneForfaitNuitee);
            $entityManager->persist($actualLigneForfaitEtape);
            $entityManager->persist($actualLigneForfaitKM);

            $entityManager->flush();
        }

        if ($formForfait->isSubmitted() && $formForfait->isValid()) {

            $allLigne = $ficheMoisUser->getLigneFraisForfait();
            foreach ($allLigne as $ligne) {

                if ($ligne->getFraisForfait()->getId() == 1) {
                    $ligne->setQuantite($formForfait->get('quantiteKM')->getData());
                } else if ($ligne->getFraisForfait()->getId() == 2) {
                    $ligne->setQuantite($formForfait->get('quantiteNuitee')->getData());
                } else if ($ligne->getFraisForfait()->getId() == 3) {
                    $ligne->setQuantite($formForfait->get('quantiteEtape')->getData());
                } else {
                    $ligne->setQuantite($formForfait->get('quantiteRepas')->getData());
                }
            }
            $entityManager->persist($ficheMoisUser);
            $entityManager->flush();
        }

        if ($formHorsForfait->isSubmitted() && $formHorsForfait->isValid()) {

            $ligne = new LigneFraisHorsForfait();

            $ligne->setLibelle($formHorsForfait->get('libelle')->getData());
            $ligne->setDate($formHorsForfait->get('date')->getData());
            $ligne->setMontant($formHorsForfait->get('montant')->getData());
            $ligne->setFicheFrais($ficheMoisUser);

            $entityManager->persist($ficheMoisUser);
            $entityManager->flush();
        }


        return $this->render('saisie_fiche/index.html.twig', [
            'controller_name' => 'SaisieFicheController',
            'actualFiche' => $ficheMoisUser,
            'formForfait' => $formForfait,
            'formHorsForfait' => $formHorsForfait,
        ]);
    }
}
