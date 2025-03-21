<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ConfirmationPasswordController extends AbstractController
{
    #[Route('/confirmation/password', name: 'app_confirmation_password')]
    public function index(): Response
    {
        return $this->render('confirmation_password/index.html.twig', [
            'controller_name' => 'ConfirmationPasswordController',
        ]);
    }
}
