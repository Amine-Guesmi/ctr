<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ResourceHumaineController extends AbstractController
{
    #[Route('/resource/humaine', name: 'app_resource_humaine')]
    public function index(): Response
    {
        return $this->render('resource_humaine/index.html.twig', [
            'controller_name' => 'ResourceHumaineController',
        ]);
    }
}
