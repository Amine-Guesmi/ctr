<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Form\UserType;
class GestionuserController extends AbstractController
{
    #[Route('/gestionuser', name: 'app_gestionuser')]
    public function index(): Response
    {
        return $this->render('gestionuser/index.html.twig', [
            'controller_name' => 'GestionuserController',
        ]);
    }
    #[Route('/gestionuser/ajouterutilisateur', name: 'app_gestionuser_ajouterutilisateur')]
    public function AjouterUtilisateur(Request $req): Response
    {
        $idcreator=1;
        $Utilisateurs = new User();
        $form = $this->createForm(UserType::class, $Utilisateurs);

        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){

            $images = $form->get('image')->getData();
            $CV = $form->get('cvFile')->getData();
                $fichier = md5(uniqid()).'.'.$images->guessExtension();
                $fichier2 = md5(uniqid()).'.'.$CV->guessExtension();
                $CV->move(
                    $this->getParameter('upload_cv'),
                    $CV
                );
                $images->move($this->getParameter('upload_image'),$fichier);
                $Utilisateurs->setUrl($fichier);
                $Utilisateurs->setCV($fichier2);

            $this->getDoctrine()->getManager()->persist($Utilisateurs);
            $this->getDoctrine()->getManager()->flush();   
            
            return $this->redirectToRoute('Utilisateurs');
        }
        return $this->render('gestionuser/ajouterutilisateur.html.twig', [
            'controller_name' => 'GestionuserController',
            'formajoutuser' => $form->createView()
        ]);
    }
    public function AjoutUtilisateurFORM(Request $req)
    {   
        return $this->render('gestionuser/ajouterutilisateur.html.twig', [
            'controller_name' => 'GestionuserController'
        ]);
    }
}
