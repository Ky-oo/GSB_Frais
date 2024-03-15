<?php

namespace App\Controller;

use App\Repository\FicheFraisRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MontantTotalPourPrimeController extends AbstractController
{
    #[Route('/montant', name: 'app_montant_total_pour_prime')]
    public function index(FicheFraisRepository $ficheFraisRepository, userRepository $userRepository): Response
    {
        $montant = 0;
        $prime = 0;

     foreach ($ficheFraisRepository->findAll() as $fiche){
         $anneeMois = $fiche->getMois();
         $annee = substr($anneeMois, -4);
         if($annee == 2023){
             $montant += $fiche->getMontantValid();
         }
     }

     $countUser = count($userRepository->findAll())-1;
        $prime = round(9.5 * $montant / 100, 2);
        $primeParEmployee = round($prime / $countUser, 2);
        return $this->render('montant_total_pour_prime/index.html.twig', [
            'controller_name' => 'MontantTotalPourPrimeController',
            'montant' => $montant,
            'prime' => $prime,
            'primeParEmployee' => $primeParEmployee
        ]);
    }
}
