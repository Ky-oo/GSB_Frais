<?php

namespace App\Controller;

use App\Entity\LigneFraisHorsForfait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteHorsForfaitController extends AbstractController
{
    #[Route('/deleteHorsForfait/{id}', name: 'app_delete_hors_forfait')]
    public function index($id, EntityManagerInterface $entityManager): Response
    {
        $fraisHorsForfait = $entityManager->getRepository(LigneFraisHorsForfait::class)->find($id);

        if ($fraisHorsForfait != null) {
            $entityManager->remove($fraisHorsForfait);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_saisie_fiche');
    }
}