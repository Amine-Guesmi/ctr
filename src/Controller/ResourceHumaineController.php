<?php

namespace App\Controller;

use DateTime;
use App\Entity\SessionRecrutement;
use App\Repository\CandidatureRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SessionRecrutementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ResourceHumaineController extends AbstractController
{
    #[Route('/resource/humaine', name: 'app_resource_humaine')]
    public function index(): Response
    {
        return $this->render('resource_humaine/index.html.twig', [
            'controller_name' => 'ResourceHumaineController',
        ]);
    } 

    #[Route('/resource/humaine/SessionRecrutement', name: 'gestion_session_recrutement')]
    public function getListSessionRecrutement(SessionRecrutementRepository $repo_session, CandidatureRepository $repo_candidat): Response
    {
        $Sessions = $repo_session->findAll();
        $SessionsActive = $repo_session->findBy(['active' => 1]);

        return $this->render('resource_humaine/ListerSessionRecrutement.html.twig', [
            'controller_name' => 'Gestion Session de Recrutement',
            'Sessions' => $Sessions,
            'NumberOfSessions' => count((array)$Sessions),
            'NumberOfCondidats' => count((array) $repo_candidat->findAll()),
            'numberOfActiveSession' => count((array)$SessionsActive)
        ]);
    } 

    #[Route('/resource/humaine/SessionRecrutement/{id}/changeEtat', name: 'app_resource_humaine_active_session')]
    public function activerSession(SessionRecrutement $session): Response
    {
        if($session){
            $entityManager = $this->getDoctrine()->getManager();
            if($session->isActive()){
                $session->setActive(0);
                $session->setDateTerminer(new \DateTime());
            }  
            else
                $session->setActive(1);
            
            $entityManager->persist($session);
            $entityManager->flush();
            return $this->redirectToRoute('gestion_session_recrutement');
        }
        
    } 

    #[Route('/resource/humaine/SessionRecrutement/create', name: 'create_session_recrutement')]
    #[Route('/resource/humaine/SessionRecrutement/{id}/edit', name: 'edit_session_recrutement')]
    public function CreationEditSessionRecrutement(Request $request, SessionRecrutement $sessionRecrutement = null, SessionRecrutementRepository $repo_session, CandidatureRepository $repo_candidat): Response
    {
        $Sessions = $repo_session->findAll();
        $SessionsActive = $repo_session->findBy(['active' => 1]);

        return $this->render('resource_humaine/formSessionRecrutement.html.twig', [
            'controller_name' => 'Gestion Session de Recrutement',
            'Sessions' => $Sessions,
            'NumberOfSessions' => count((array)$Sessions),
            'NumberOfCondidats' => count((array) $repo_candidat->findAll()),
            'numberOfActiveSession' => count((array)$SessionsActive)
        ]);
    } 
}
