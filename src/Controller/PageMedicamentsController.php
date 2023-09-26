<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageMedicamentsController extends AbstractController
{
    #[Route('/page/medicaments', name: 'app_page_medicaments')]
    public function index(): Response
    {
        return $this->render('page_medicaments/index.html.twig', [
            'controller_name' => 'PageMedicamentsController',
        ]);
    }
}
