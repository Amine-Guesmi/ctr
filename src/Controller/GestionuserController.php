<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Form\UserType;
use App\Form\UpdateUserType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
class GestionuserController extends AbstractController
{

    #[Route('/gestionuser', name: 'app_gestionuser')]
    public function index(): Response
    {   $Nombre_Admin=0;
        $Nombre_RLogistique=0;
        $Nombre_RRH=0;
        $Nombre_RS=0;
        $repo=$this->getDoctrine()->getRepository(User::class);
        $UtilisateursList=$repo->findAll();
        //Statistique
        //$Nombre_Admin=$UtilisateursList
        dump($UtilisateursList);

        ///Statistiques
        foreach($UtilisateursList as $elem){
            if($elem->getRoles()[0] === "ROLE_ADMIN"){
                $Nombre_Admin++;
            }
            if($elem->getRoles()[0] === "ROLE_RESPONSABLE_RH"){
                $Nombre_RRH++;
            }
            if($elem->getRoles()[0] === "ROLE_RESPONSABLE_LOGISTIQUE"){
                $Nombre_RLogistique++;
            }
            if($elem->getRoles()[0] === "ROLE_RESPONSABLE_STOCK"){
                $Nombre_RS++;
            }

                
        }
        return $this->render('gestionuser/index.html.twig', [
            'controller_name' => 'GestionuserController',
            'UtilisateursList'=>$UtilisateursList,
            'Nombre_Admin'=>$Nombre_Admin,
            'Nombre_RLogistique'=>$Nombre_RLogistique,
            'Nombre_RRH'=>$Nombre_RRH,
            'Nombre_RS'=>$Nombre_RS
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
    public function ModifierUser(User $User, Request $req,int $id, UserPasswordHasherInterface $passwordHasher)
{   $em = $this->getDoctrine()->getManager();
    $User = $em->getRepository(User::class)->find($id);
    //DD($User);
    //DD($User->getRoles()[0]);
    $oldimage=$User->getImage();
    $oldcv=$User->getCvFile();
    //DD($User->getRoles());
    $oldrole=$User->getRoles()[0];
    
    $oldpassword=$User->getPassword();

    $formedit = $this->createForm(UpdateUserType::class, $User);
    $formedit->handleRequest($req);
    if($formedit->isSubmitted() && $formedit->isValid()){
        $images = $formedit->get('image')->getData();
        $CV = $formedit->get('cvFile')->getData();
        if($images != null){
            $fichier = md5(uniqid()).'.'.$images->guessExtension();
            $images->move($this->getParameter('upload_image').'images',$fichier);
            $User->setImage($fichier);
        }
        else{
            $User->setImage($oldimage);
        }
        if($CV != null){
            $fichier2 = md5(uniqid()).'.'.$CV->guessExtension();
            $CV->move(
                $this->getParameter('upload_image').'cvs',
                $fichier2
            );
            $User->setCvFile($fichier2);
        }
        else{
            $User->setCvFile($oldcv);
        }
        if($req->request->get("SelectUserRole") != $oldrole){
            $User->setRoles([$req->request->get("SelectUserRole")]);
        }
        else{
            $User->setRoles([$oldrole]);
        }
        //$User->setRoles([$req->request->get("SelectUserRole")]);
        //
        if($formedit->get('password')->getData() != $oldpassword){
            $User->setPassword($passwordHasher->hashPassword($User, $formedit->get('password')->getData()));
        }
        else{
            $User->setPassword($oldpassword);
        }
        //$passwordHasher->hashPassword($User, $req->request->get("userpassword"));
        //$User->setPassword($req->request->get("userpassword"));
       // $User->setPassword($passwordHasher);
        
        $this->getDoctrine()->getManager()->persist($User);
        $this->getDoctrine()->getManager()->flush();   
        
        return $this->redirectToRoute('app_gestionuser');
    }
        return $this->render('gestionuser/modifierutilisateur.html.twig', [
            'controller_name' => 'GestionUserController',
            'formedituser' => $formedit->createView(),
            'id' => $User->getId(),
            'oldimage'=>$oldimage,
            'oldcv'=>$oldcv,
            'oldrole'=>$oldrole
        ]);
    }
    #[Route('/gestionuser/deleteutilisateur/{id}', name: 'deleteutilisateur')]
    public function delete(Request $request, $id): Response
    { $em = $this->getDoctrine()->getManager();
        $User = $em
            ->getRepository(User::class)
            ->find($id);
        if($User->getRoles()[0] === "ROLE_ADMIN"){
            $this->addFlash('error', 'Vous ne pouvez pas supprimer un administrateur');
            return $this->redirectToRoute('app_gestionuser');
        }
        try{
            $em->remove($User);
            $em->flush();
            $this->addFlash('success', 'Utilisateur supprimé avec succès');
        }catch(\Exception $e){
            $this->addFlash('error', 'Erreur lors de la suppression');
        }
        return $this->redirectToRoute('app_gestionuser');
    }
    public function AjoutUtilisateurFORM(Request $req)
    {   
        return $this->render('gestionuser/ajouterutilisateur.html.twig', [
            'controller_name' => 'GestionuserController'
        ]);
    }
}
