<?php

namespace App\Controller;

use App\Entity\FicheFrais;
use App\Form\MesFichesType;
use App\Repository\FicheFraisRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MesFichesController extends AbstractController
{
    #[Route('/mesFiches', name: 'app_mes_fiches')]
    public function index(Request $request, FicheFraisRepository $ficheFraisRepository, FicheFrais $ficheFrais, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $allFiches = $ficheFraisRepository->findBy(["user" => $user]);

        $form = $this->createForm(MesFichesType::class, null, ['allFiches' => $allFiches    ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $selectedFiche = $form->get('listMois')->getData();
            return $this->render('mes_fiches/index.html.twig', [
                'controller_name' => 'MesFichesController',
                'ficheDate' => $selectedFiche,
                'form' => $form->createView(),
            ]);
        }

        return $this->render('mes_fiches/index.html.twig', [
            'controller_name' => 'MesFichesController',
        ]);
    }
}
