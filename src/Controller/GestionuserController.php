<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
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
        $repo=$this->getDoctrine()->getRepository(User::class);
        $UtilisateursList=$repo->findAll();
        return $this->render('gestionuser/index.html.twig', [
            'controller_name' => 'GestionuserController',
            'UtilisateursList'=>$UtilisateursList,
        ]);
    }
    #[Route('/gestionuser/ajouterutilisateur', name: 'AjouterUtilisateur')]
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
                    $this->getParameter('upload_image').'cvs',
                    $fichier2
                );
                $images->move($this->getParameter('upload_image').'images',$fichier);
                $Utilisateurs->setImage($fichier);
                $Utilisateurs->setCvFile($fichier2);

            $this->getDoctrine()->getManager()->persist($Utilisateurs);
            $this->getDoctrine()->getManager()->flush();   
            
            return $this->redirectToRoute('app_gestionuser');
        }
        return $this->render('gestionuser/ajouterutilisateur.html.twig', [
            'controller_name' => 'GestionuserController',
            'formajoutuser' => $form->createView()
        ]);
    }
    #[Route('/gestionuser/modifierutilisateur/{id}', name: 'ModifierUser')]
    public function ModifierUser(User $User, Request $req,int $id)
{   $User->setImage(new File($this->getParameter('upload_image').'images/'.$User->getImage()));
    $User->setCvFile(new File($this->getParameter('upload_image').'cvs/'.$User->getCvFile()));
        $formedit = $this->createForm(UserType::class, $User);
        $formedit->handleRequest($req);
        if($formedit->isSubmitted() && $formedit->isValid()){
            $this->getDoctrine()->getManager()->persist($User); 
            $this->getDoctrine()->getManager()->flush(); 
              
        }
        return $this->render('gestionuser/modifierutilisateur.html.twig', [
            'controller_name' => 'GestionUserController',
            'formedituser' => $formedit->createView(),
            'id' => $User->getId()
        ]);
    }
    #[Route('/gestionuser/deleteutilisateur/{id}', name: 'deleteutilisateur')]
    public function delete(Request $request, $id): Response
    { $em = $this->getDoctrine()->getManager();
        $User = $em
            ->getRepository(User::class)
            ->find($id);
        $em->remove($User);
        $em->flush();
        return $this->redirectToRoute('app_gestionuser');
    }
    public function AjoutUtilisateurFORM(Request $req)
    {   
        return $this->render('gestionuser/ajouterutilisateur.html.twig', [
            'controller_name' => 'GestionuserController'
        ]);
    }
}
