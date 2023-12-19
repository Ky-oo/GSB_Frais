<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MontantTotalPourPrimeController extends AbstractController
{
    #[Route('/montant/total/pour/prime', name: 'app_montant_total_pour_prime')]
    public function index(): Response
    {
        return $this->render('montant_total_pour_prime/index.html.twig', [
            'controller_name' => 'MontantTotalPourPrimeController',
        ]);
    }
}
