<?php

namespace App\Controller;

use App\Form\AllUserType;
use App\Form\ChangeEtatType;
use App\Repository\EtatRepository;
use App\Repository\FicheFraisRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GestionComptableController extends AbstractController
{
    #[Route('/gestion/comptable', name: 'app_gestion_comptable')]
    public function index(Request $request, FicheFraisRepository $ficheFraisRepository, UserRepository $userRepository,
                          EtatRepository $etatRepository, EntityManagerInterface $entityManager): Response
    {

        $form = $this->createForm(allUserType::class, null, ['allUser' => $userRepository->findAll()]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $selectedUser = $form->get('selectionner')->getData();
            $allFicheFrais = $ficheFraisRepository->findBy(["user" => $selectedUser]);
            $formEtat = $this->createForm(changeEtatType::class, null, ['allEtat' => $etatRepository->findAll()]);
            $formEtat->handleRequest($request);

            if($formEtat->isSubmitted() && $formEtat->isValid()) {
                $selectedEtat = $formEtat->get('etat')->getData();
                $selectedFiche = $formEtat->get('fiche')->getData();
                $selectedFiche->setEtat($selectedEtat);
                $entityManager->persist($selectedFiche);
                $entityManager->flush();

                return $this->render('gestion_comptable/index.html.twig', [
                    'controller_name' => 'GestionComptableController',
                    'form' => $form->createView()
                ]);

            }
            return $this->render('gestion_comptable/index.html.twig', [
                'controller_name' => 'GestionComptableController',
                'allFicheFrais' => $allFicheFrais,
                'formEtat' => $formEtat->createView(),
                'form' => $form->createView()
            ]);
        }

        return $this->render('gestion_comptable/index.html.twig', [
            'controller_name' => 'GestionComptableController',
            'form' => $form->createView()
        ]);
    }
}
