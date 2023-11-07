<?php

namespace App\Controller;

use App\Repository\FicheFraisRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MesFichesController extends AbstractController
{
    #[Route('/mesFiches', name: 'app_mes_fiches')]
    public function index(Request $request, FicheFraisRepository $ficheFraisRepository): Response
    {
        $theFiche = null;

        if($request->get("dateFicheFrais") != null) {

            $dateTime = new \DateTime($request->get("dateFicheFrais"));
            $dateFormate = $dateTime->format('F Y');

            $theFiche = $ficheFraisRepository->findOneBy(["mois"=>$dateFormate, "user"=>$this->getUser()]);
        }


        return $this->render('mes_fiches/index.html.twig', [
            'controller_name' => 'MesFichesController',
            'ficheDate' => $theFiche
        ]);
    }
}
