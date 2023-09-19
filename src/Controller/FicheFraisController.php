<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FicheFraisController extends AbstractController
{
    #[Route('/fiche/frais', name: 'app_fiche_frais')]
    public function index(): Response
    {
        return $this->render('fiche_frais/index.html.twig', [
            'controller_name' => 'FicheFraisController',
        ]);
    }
}
