<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;

class RegistrationController extends AbstractController
{

    #[Route('/registration', name: 'app_registration')]
    public function index(ManagerRegistry $doctrine, UserPasswordHasherInterface $passwordHasher): Response
    {

        $user = new User();
        $plaintextPassword = "GSBFraisADMIN2023";
        $user->setEmail("admin@gsb.fr");
        $user->setRoles(["ROLE_SUPER_ADMIN"]);
        $user->setNom("admin");
        $user->setPrenom("admin");
        $user->setVille("Annecy");
        $user->setCp("74000");
        $user->setAdresse("30 route du Fiere");
        $user->setDateEmbauche(new \DateTime(01/01/2001));


        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $plaintextPassword
        );
        $user->setPassword($hashedPassword);

        $manager = $doctrine->getManager();
        $manager->persist($user);
        $manager->flush();


        return $this->render('registration/index.html.twig', [
            'controller_name' => 'RegistrationController',
        ]);
    }
}
