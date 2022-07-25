<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Chauffeur;
use App\Form\ChauffeurType;
class GestionchauffeurController extends AbstractController
{
    #[Route('/gestionchauffeur', name: 'app_gestionchauffeur')]
    public function index(): Response
    {
        $repo=$this->getDoctrine()->getRepository(Chauffeur::class);
        $ChauffeursList=$repo->findAll();
        return $this->render('gestionchauffeur/index.html.twig', [
            'controller_name' => 'GestionchauffeurController',
            'ChauffeursList'=>$ChauffeursList,
        ]);
    }
    #[Route('/gestionchauffeur/ajouterchauffeur', name: 'AjouterChauffeur')]
    public function AjouterChauffeur(Request $req): Response
    {
        $idcreator=1;
        $Chauffeurs = new Chauffeur();
        $form = $this->createForm(ChauffeurType::class, $Chauffeurs);

        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){

            $images = $form->get('image')->getData();
                $fichier = md5(uniqid()).'.'.$images->guessExtension();
                $images->move($this->getParameter('upload_image_chauffeur'),$fichier);
                $Chauffeurs->setImage($fichier);

            $this->getDoctrine()->getManager()->persist($Chauffeurs);
            $this->getDoctrine()->getManager()->flush();   
            
            return $this->redirectToRoute('app_gestionchauffeur');
        }
        return $this->render('gestionchauffeur/ajouterchauffeur.html.twig', [
            'controller_name' => 'GestionchauffeurController',
            'formajoutchauffeur' => $form->createView()
        ]);
    }
}
