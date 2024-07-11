<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ConfirmCommandeController extends AbstractController
{
    #[Route('/confirm/commande', name: 'app_confirm_commande')]
    public function index(): Response
    {
        return $this->render('confirm_commande/index.html.twig', [
            'controller_name' => 'ConfirmCommandeController',
        ]);
    }
}
