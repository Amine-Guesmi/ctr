<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Employer;
use App\Entity\User;
use App\Entity\Department;
use App\Form\EmployeType;

class GestionemployeesController extends AbstractController
{
    #[Route('/Employees', name: 'app_gestionemployees')]
    public function index(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Employer::class);
        $EmployersList = $repo->findAll();
        return $this->render('gestionemployees/index.html.twig', [
            'controller_name' => 'GestionemployeesController',
            'EmployersList' => $EmployersList,
        ]);
    }
    //Ajouter
    #[Route('/Employers/ajouteremployee', name: 'AjouterEmployer')]
    public function AjouterEmployer(Request $req): Response
    {
        $idcreator = 1;
        $Employers = new Employer();
        //
        
        $UsersList = $this->getDoctrine()->getRepository(User::class)->findAll();
        $DepartementsList=$this->getDoctrine()->getRepository(Department::class)->findAll();
        
        //
        $form = $this->createForm(EmployeType::class, $Employers);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            //Departement
            $idDepartement=$req->request->get('SelectDepartement');
            $Departement=$this->getDoctrine()->getRepository(Department::class)->find((int)$idDepartement);
            $Employers->setDepartment($Departement);
            //User
            $idUser=$req->request->get('SelectUser');
            $User=$this->getDoctrine()->getRepository(User::class)->find((int)$idUser);
            $Employers->setUser($User);
            //$Employers->setUser($this->getDoctrine()->getRepository(User::class)->find($req->request->get('SelectUser')));
           // $Employers->setDepartment($this->getDoctrine()->getRepository(Department::class)->find($req->request->get('SelectDepartement')));
            //
            $images = $form->get('Image')->getData();
            $CV = $form->get('cv')->getData();
            $fichier = md5(uniqid()) . '.' . $images->guessExtension();
            $fichier2 = md5(uniqid()) . '.' . $CV->guessExtension();
            $CV->move(
                $this->getParameter('upload_image') . 'cvs/employees',
                $fichier2
            );
            $images->move($this->getParameter('upload_image_employee') . '/', $fichier);
            $Employers->setImage($fichier);
            $Employers->setCv($fichier2);
            $this->getDoctrine()->getManager()->persist($Employers);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('app_gestionemployees');
        }
        return $this->render('gestionemployees/ajouteremployee.html.twig', [
            'controller_name' => 'GestionemployeeController',
            'formajoutemployee' => $form->createView(),
            'UsersList' => $UsersList,
            'DepartementsList' => $DepartementsList
        ]);
    }
    //Modifier
    #[Route('/Employers/modifieremployee/{id}', name: 'ModifierEmployer')]
    public function ModifierEmployer(Employer $Employer, Request $req, int $id)
    {
        $Employer->setImage(new File($this->getParameter('upload_image') . 'images/' . $Employer->getImage()));
        $Employer->setCv(new File($this->getParameter('upload_image') . 'cvs/' . $Employer->getCv()));
        $formedit = $this->createForm(EmployeType::class, $Employer);
        $formedit->handleRequest($req);
        if ($formedit->isSubmitted() && $formedit->isValid()) {
            $this->getDoctrine()->getManager()->persist($Employer);
            $this->getDoctrine()->getManager()->flush();
        }
        return $this->render('gestionemployees/modifieremployee.html.twig', [
            'controller_name' => 'GestionEmployerController',
            'formeditemployee' => $formedit->createView(),
            'id' => $Employer->getId()
        ]);
    }
    //Supemployeer
    #[Route('/Employers/delete/{id}', name: 'deleteemployee')]
    public function delete(Request $request, $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $Employer = $em
            ->getRepository(Employer::class)
            ->find($id);
        $em->remove($Employer);
        $em->flush();
        return $this->redirectToRoute('app_gestionemployees');
    }
}
