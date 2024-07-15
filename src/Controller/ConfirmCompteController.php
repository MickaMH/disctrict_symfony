<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ConfirmCompteController extends AbstractController
{
    #[Route('/confirm/compte', name: 'app_confirm_compte')]
    public function index(): Response
    {
        return $this->render('confirm_compte/index.html.twig', [
            'controller_name' => 'ConfirmCompteController',
        ]);
    }
}
