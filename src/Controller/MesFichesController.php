<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MesFichesController extends AbstractController
{
    #[Route('/mesFiches', name: 'app_mes_fiches')]
    public function index(): Response
    {
        return $this->render('mes_fiches/index.html.twig', [
            'controller_name' => 'MesFichesController',
        ]);
    }
}
