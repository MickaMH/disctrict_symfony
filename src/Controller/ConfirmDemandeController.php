<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ConfirmDemandeController extends AbstractController
{
    #[Route('/confirm/demande', name: 'app_confirm_demande')]
    public function index(): Response
    {
        return $this->render('confirm_demande/index.html.twig', [
            'controller_name' => 'ConfirmDemandeController',
        ]);
    }
}
