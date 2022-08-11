<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\VoyageEffectuer;
use App\Form\VoyageEffectuerType;
class GestionvoyagesController extends AbstractController
{
    #[Route('/Voyages', name: 'app_gestionvoyages')]
    public function index(): Response
    {
        $repo=$this->getDoctrine()->getRepository(VoyageEffectuer::class);
        $VoyagesList=$repo->findAll();
        return $this->render('gestionvoyages/index.html.twig', [
            'controller_name' => 'GestionvoyagesController',
            'VoyagesList'=>$VoyagesList,
        ]);
    }
    //Ajouter
    #[Route('/Voyages/ajoutervoyage', name: 'AjouterVoyage')]
    public function AjouterVoyage(Request $req): Response
    {
        $idcreator=1;
        $Voyages = new VoyageEffectuer();
        $form = $this->createForm(VoyageEffectuerType::class, $Voyages);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $this->getDoctrine()->getManager()->persist($Voyages);
            $this->getDoctrine()->getManager()->flush();   
            
            return $this->redirectToRoute('app_gestionvoyages');
        }
        return $this->render('gestionvoyages/ajoutervoyage.html.twig', [
            'controller_name' => 'GestionvoyageController',
            'formajoutvoyage' => $form->createView()
        ]);
    }
    //Modifier
    #[Route('/Voyages/modifiervoyage/{id}', name: 'ModifierVoyage')]
    public function ModifierVoyage(VoyageEffectuer $Voyage, Request $req,int $id)
{   
        $formedit = $this->createForm(VoyageEffectuerType::class, $Voyage);
        $formedit->handleRequest($req);
        if($formedit->isSubmitted() && $formedit->isValid()){
            $this->getDoctrine()->getManager()->persist($Voyage); 
            $this->getDoctrine()->getManager()->flush(); 
              
        }
        return $this->render('gestionvoyages/modifiervoyage.html.twig', [
            'controller_name' => 'GestionVoyageController',
            'formeditvoyage' => $formedit->createView(),
            'id' => $Voyage->getId()
        ]);
    }
    //Supvoyager
    #[Route('/Voyages/delete/{id}', name: 'deletevoyage')]
    public function delete(Request $request, $id): Response
    { $em = $this->getDoctrine()->getManager();
        $Voyage = $em
            ->getRepository(VoyageEffectuer::class)
            ->find($id);
        $em->remove($Voyage);
        $em->flush();
        return $this->redirectToRoute('app_gestionvoyages');
    }
}
