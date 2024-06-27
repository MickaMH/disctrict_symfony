<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PolitConfidController extends AbstractController
{
    #[Route('/polit/confid', name: 'app_polit_confid')]
    public function index(): Response
    {
        return $this->render('polit_confid/index.html.twig', [
            'controller_name' => 'PolitConfidController',
        ]);
    }
}
