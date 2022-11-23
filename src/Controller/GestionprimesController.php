<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Prime;
use App\Form\PrimeType;
class GestionprimesController extends AbstractController
{
    #[Route('/Primes', name: 'app_gestionprimes')]
    public function index(): Response
    {
        $repo=$this->getDoctrine()->getRepository(Prime::class);
        $PrimesList=$repo->findAll();
        return $this->render('gestionprimes/index.html.twig', [
            'controller_name' => 'GestionprimesController',
            'PrimesList'=>$PrimesList,
        ]);
    }
     //Ajouter
     #[Route('/Primes/ajouterprime', name: 'AjouterPrime')]
     public function AjouterPrime(Request $req): Response
     {
         $idcreator=1;
         $Primes = new Prime();
         $form = $this->createForm(PrimeType::class, $Primes);
         $form->handleRequest($req);
         if($form->isSubmitted() && $form->isValid()){
             $this->getDoctrine()->getManager()->persist($Primes);
             $this->getDoctrine()->getManager()->flush();   
             
             return $this->redirectToRoute('app_gestionprimes');
         }
         return $this->render('gestionprimes/ajouterprime.html.twig', [
             'controller_name' => 'GestionprimeController',
             'formajoutprime' => $form->createView()
         ]);
     }
     //Modifier
     #[Route('/Primes/modifierprime/{id}', name: 'ModifierPrime')]
     public function ModifierPrime(Prime $Prime, Request $req,int $id)
 {   
         $formedit = $this->createForm(PrimeType::class, $Prime);
         $formedit->handleRequest($req);
         if($formedit->isSubmitted() && $formedit->isValid()){
             $this->getDoctrine()->getManager()->persist($Prime); 
             $this->getDoctrine()->getManager()->flush(); 
                return $this->redirectToRoute('app_gestionprimes');
         }
         return $this->render('gestionprimes/modifierprime.html.twig', [
             'controller_name' => 'GestionPrimeController',
             'formeditprime' => $formedit->createView(),
             'id' => $Prime->getId()
         ]);
     }
     //Supprimer
     #[Route('/Primes/deleteprime/{id}', name: 'deleteprime')]
     public function delete(Request $request, $id): Response
     { $em = $this->getDoctrine()->getManager();
         $Prime = $em
             ->getRepository(Prime::class)
             ->find($id);
             try{
                    $em->remove($Prime);
                    $em->flush();
             }catch(\Exception $e){
                 $this->addFlash('error', 'Impossible de supprimer cette prime');
                 return $this->redirectToRoute('app_gestionprimes');
             }
         return $this->redirectToRoute('app_gestionprimes');
     }
}
