<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Department;
use App\Form\DepartementType;
class GestiondepartementsController extends AbstractController
{
    #[Route('/Departements', name: 'app_gestiondepartements')]
    public function index(): Response
    {
        $repo=$this->getDoctrine()->getRepository(Department::class);
        $DepartementsList=$repo->findAll();
        return $this->render('gestiondepartements/index.html.twig', [
            'controller_name' => 'GestiondepartementsController',
            'DepartementsList'=>$DepartementsList,
        ]);
    }
    //Ajouter
    #[Route('/Departements/ajouterdepartement', name: 'AjouterDepartement')]
    public function AjouterDepartement(Request $req): Response
    {
        $idcreator=1;
        $Departements = new Department();
        $form = $this->createForm(DepartementType::class, $Departements);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $this->getDoctrine()->getManager()->persist($Departements);
            $this->getDoctrine()->getManager()->flush();   
            
            return $this->redirectToRoute('app_gestiondepartements');
        }
        return $this->render('gestiondepartements/ajouterdepartement.html.twig', [
            'controller_name' => 'GestiondepartementController',
            'formajoutdepartement' => $form->createView()
        ]);
    }
    //Modifier
    #[Route('/Departements/modifierdepartement/{id}', name: 'ModifierDepartement')]
    public function ModifierDepartement(Department $Departement, Request $req,int $id)
{   
        $formedit = $this->createForm(DepartementType::class, $Departement);
        $formedit->handleRequest($req);
        if($formedit->isSubmitted() && $formedit->isValid()){
            $this->getDoctrine()->getManager()->persist($Departement); 
            $this->getDoctrine()->getManager()->flush(); 
            return $this->redirectToRoute('app_gestiondepartements');
        }
        return $this->render('gestiondepartements/modifierdepartement.html.twig', [
            'controller_name' => 'GestionDepartementController',
            'formeditdepartement' => $formedit->createView(),
            'id' => $Departement->getId()
        ]);
    }
    //Supprimer
    #[Route('/Departements/deletedepartement/{id}', name: 'deletedepartement')]
    public function delete(Request $request, $id): Response
    { $em = $this->getDoctrine()->getManager();
        $Departement = $em
            ->getRepository(Department::class)
            ->find($id);
            try{
                $em->remove($Departement);
                $em->flush();}
                catch(\Exception $e){
                    $this->addFlash('error', 'Impossible de supprimer ce département');
                    return $this->redirectToRoute('app_gestiondepartements');
                }
        return $this->redirectToRoute('app_gestiondepartements');
    }
}
