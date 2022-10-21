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
        $Nbr_chauffeurs=count($ChauffeursList);
        return $this->render('gestionchauffeur/index.html.twig', [
            'controller_name' => 'GestionchauffeurController',
            'ChauffeursList'=>$ChauffeursList,
            'Nbr_chauffeurs'=>$Nbr_chauffeurs
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
            if($images!=null){
                $fichier = md5(uniqid()).'.'.$images->guessExtension();
                $images->move($this->getParameter('upload_image_chauffeur'),$fichier);
                $Chauffeurs->setImage($fichier);
            }
            $this->getDoctrine()->getManager()->persist($Chauffeurs);
            $this->getDoctrine()->getManager()->flush();   
            
            return $this->redirectToRoute('app_gestionchauffeur');
        }
        return $this->render('gestionchauffeur/ajouterchauffeur.html.twig', [
            'controller_name' => 'GestionchauffeurController',
            'formajoutchauffeur' => $form->createView()
        ]);
    }
    #[Route('/gestionchauffeur/modifierchauffeur/{id}', name: 'ModifierChauffeur')]
    public function ModifierChauffeur(Chauffeur $Chauffeur, Request $req,int $id)
{       $oldimagechauffeur=$Chauffeur->getImage();
        $Chauffeur->setImage(new File($this->getParameter('upload_image_chauffeur').'/'.$Chauffeur->getImage()));
        $formeditchauffeur = $this->createForm(ChauffeurType::class, $Chauffeur);
        $formeditchauffeur->handleRequest($req);
        if($formeditchauffeur->isSubmitted() && $formeditchauffeur->isValid()){
            $images = $formeditchauffeur->get('image')->getData();
            if($images!=null){
                $fichier = md5(uniqid()).'.'.$images->guessExtension();
                $images->move($this->getParameter('upload_image_chauffeur'),$fichier);
                $Chauffeur->setImage($fichier);
            }
            $this->getDoctrine()->getManager()->persist($Chauffeur);
            $this->getDoctrine()->getManager()->flush();   
            
            return $this->redirectToRoute('app_gestionchauffeur');
        }
        return $this->render('gestionchauffeur/modifierchauffeur.html.twig', [
            'controller_name' => 'GestionChauffeurController',
            'formeditchauffeur' => $formeditchauffeur->createView(),
            'id' => $Chauffeur->getId(),
            'oldimagechauffeur'=>$oldimagechauffeur,
        ]);
    }
    #[Route('/gestionchauffeur/deletechauffeur/{id}', name: 'deletechauffeur')]
    public function delete(Request $request, $id): Response
    { $em = $this->getDoctrine()->getManager();
        $Chauffeur = $em
            ->getRepository(Chauffeur::class)
            ->find($id);
        $em->remove($Chauffeur);
        $em->flush();
        return $this->redirectToRoute('app_gestionchauffeur');
    }
}
