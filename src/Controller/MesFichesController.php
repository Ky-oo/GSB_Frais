<?php

namespace App\Controller;

use App\Entity\FicheFrais;
use App\Form\MesFichesType;
use App\Repository\FicheFraisRepository;
use App\Repository\LigneFraisForfaitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MesFichesController extends AbstractController
{
    #[Route('/mesFiches', name: 'app_mes_fiches')]
    public function index(Request $request, FicheFraisRepository $ficheFraisRepository): Response
    {
        $user = $this->getUser();
        $allFiches = $ficheFraisRepository->findBy(["user" => $user]);
        $form = $this->createForm(MesFichesType::class, null, ['allFiches' => $allFiches]);
        $form->handleRequest($request);
        $ficheDate = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $totalKm = 0;
            $totalEtape = 0;
            $totalNuit = 0;
            $totalRepas = 0;

            $selectedFiche = $form->get('listMois')->getData();
            foreach (  $selectedFiche->getLigneFraisForfait() as $ligne){
                if($ligne->getFraisForfait()->getId() == 1){
                    $totalKm = $ligne->getQuantite();
                } elseif ($ligne->getFraisForfait()->getId() == 2){
                    $totalEtape = $ligne->getQuantite();
                } elseif ($ligne->getFraisForfait()->getId() == 3){
                    $totalNuit = $ligne->getQuantite();
                } else {
                    $totalRepas = $ligne->getQuantite();
                }
            }


            return $this->render('mes_fiches/index.html.twig', [
                'controller_name' => 'MesFichesController',
                'ficheDate' => $selectedFiche,
                'form' => $form->createView(),
                'totalKm' => $totalKm,
                'totalEtape' => $totalEtape,
                'totalNuit' => $totalNuit,
                'totalRepas' => $totalRepas
            ]);
        }

        return $this->render('mes_fiches/index.html.twig', [
            'controller_name' => 'MesFichesController',
            'form' => $form,
            'ficheDate' => $ficheDate,
        ]);
    }
}
