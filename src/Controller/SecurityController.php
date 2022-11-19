<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, UserPasswordHasherInterface $passwordHasher): Response
    {/*
        $user = new User();
        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            "96794628"
        );
        dd($hashedPassword);*/

        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_gestionuser');
        }
        if ($this->isGranted('ROLE_RESPONSABLE_RH')) {
            return $this->redirectToRoute('gestion_session_recrutement');
        }
        if ($this->isGranted('ROLE_RESPONSABLE_LOGISTIQUE')) {
            return $this->redirectToRoute('app_gestionchauffeur');
        }
        if ($this->isGranted('ROLE_RESPONSABLE_STOCK')) {
            return $this->redirectToRoute('app_gestionequipements');
        }


        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }
    

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
