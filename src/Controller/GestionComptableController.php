<?php

namespace App\Controller;

use App\Form\AllUserType;
use App\Form\ChangeEtatType;
use App\Form\MonthType;
use App\Repository\EtatRepository;
use App\Repository\FicheFraisRepository;
use App\Repository\UserRepository;
use DateTime;
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
        $view = 0;
        $formattedDate = null;
        $allFicheFraisMois = null;

        if ($request->get('formatedDate') != null) {
            $formattedDate = $request->get('formatedDate');
            $allFicheFraisMois = $ficheFraisRepository->findBy(["mois" => $formattedDate]);
        }

        if ($request->get('view') != null) {
            $view = $request->get('view');
        }

        $form = $this->createForm(allUserType::class, null, ['allUser' => $userRepository->findAll()]);
        $form->handleRequest($request);

        $formMois = $this->createForm(MonthType::class);
        $formMois->handleRequest($request);

        $formEtat = $this->createForm(changeEtatType::class, null, ['allEtat' => $etatRepository->findAll()]);
        $formEtat->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $selectedUser = $form->get('selectionner')->getData();
            $allFicheFrais = $ficheFraisRepository->findBy(["user" => $selectedUser]);

            return $this->redirectToRoute('app_gestion_comptable', [
                'view' => $view,
                'allFicheFrais' => $allFicheFrais,
            ]);
        }

        if ($formMois->isSubmitted() && $formMois->isValid()) {
            $selectedMonth = $formMois->get('month')->getData();
            $selectedYear = $formMois->get('year')->getData();

            $monthName = date('F', mktime(0, 0, 0, $selectedMonth, 1));

            $formattedDate = $monthName . ' ' . $selectedYear;

            return $this->redirectToRoute('app_gestion_comptable', [
                'formatedDate' => $formattedDate,
                'view' => $view,
                'allFicheFraisMois' => $allFicheFraisMois,
            ]);
        }

        if ($formEtat->isSubmitted() && $formEtat->isValid()){
            $selectedEtat = $formEtat->get('etat')->getData();
            foreach ($allFicheFraisMois as $selectedFiche){
                $selectedFiche->setEtat($selectedEtat);
                $entityManager->persist($selectedFiche);
                $entityManager->flush();
            }

            return $this->redirectToRoute('app_gestion_comptable', [
                'view' => $view,
            ]);
        }


        return $this->render('gestion_comptable/index.html.twig', [
            'controller_name' => 'GestionComptableController',
            'form' => $form->createView(),
            'formMois' => $formMois->createView(),
            'view' => $view,
            'formEtat' => $formEtat->createView(),
            'allFicheFraisMois' => $allFicheFraisMois,
        ]);
    }
}
