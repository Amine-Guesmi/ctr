<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Equipement;
use App\Form\EquipementType;
class GestionequipementsController extends AbstractController
{
    #[Route('/Equipements', name: 'app_gestionequipements')]
    public function index(): Response
    {
        $repo=$this->getDoctrine()->getRepository(Equipement::class);
        $EquipementsList=$repo->findAll();
        return $this->render('gestionequipements/index.html.twig', [
            'controller_name' => 'GestionequipementsController',
            'EquipementsList'=>$EquipementsList,
        ]);
    }
    #[Route('/Equipements/ajouterequipement', name: 'AjouterEquipement')]
    public function AjouterEquipement(Request $req): Response
    {
        $idcreator=1;
        $Equipements = new Equipement();
        $form = $this->createForm(EquipementType::class, $Equipements);

        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){

            $images = $form->get('image')->getData();
                $fichier = md5(uniqid()).'.'.$images->guessExtension();
                $images->move($this->getParameter('upload_image_equipement'),$fichier);
                $Equipements->setImage($fichier);

            $this->getDoctrine()->getManager()->persist($Equipements);
            $this->getDoctrine()->getManager()->flush();   
            
            return $this->redirectToRoute('app_gestionequipements');
        }
        return $this->render('gestionequipements/ajouterequipement.html.twig', [
            'controller_name' => 'GestionequipementController',
            'formajoutequipement' => $form->createView()
        ]);
    }
    #[Route('/Equipements/modifierequipement/{id}', name: 'ModifierEquipement')]
    public function ModifierEquipement(Equipement $Equipement, Request $req,int $id)
{       $oldimage=$Equipement->getImage();
        $Equipement->setImage(new File($this->getParameter('upload_image_equipement').'/'.$Equipement->getImage()));
        $formedit = $this->createForm(EquipementType::class, $Equipement);
        $formedit->handleRequest($req);
        if($formedit->isSubmitted() && $formedit->isValid()){
            if($formedit->get('image')->getData() != null){
                $images = $formedit->get('image')->getData();
                $fichier = md5(uniqid()).'.'.$images->guessExtension();
                $images->move($this->getParameter('upload_image_equipement'),$fichier);
                $Equipement->setImage($fichier);
            }else{
                $Equipement->setImage($oldimage);
            }
            $this->getDoctrine()->getManager()->persist($Equipement); 
            $this->getDoctrine()->getManager()->flush(); 
            return $this->redirectToRoute('app_gestionequipements');
              
        }
        return $this->render('gestionequipements/modifierequipement.html.twig', [
            'controller_name' => 'GestionEquipementController',
            'formeditequipement' => $formedit->createView(),
            'id' => $Equipement->getId(),
            'oldimage'=>$oldimage
        ]);
    }
    #[Route('/Equipements/deleteequipement/{id}', name: 'deleteequipement')]
    public function delete(Request $request, $id): Response
    { $em = $this->getDoctrine()->getManager();
        $Equipement = $em
            ->getRepository(Equipement::class)
            ->find($id);
        $em->remove($Equipement);
        $em->flush();
        return $this->redirectToRoute('app_gestionequipements');
    }
}
