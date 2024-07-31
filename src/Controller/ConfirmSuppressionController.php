<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ConfirmSuppressionController extends AbstractController
{
    #[Route('/confirm/suppression', name: 'app_confirm_suppression')]
    public function index(): Response
    {
        return $this->render('confirm_suppression/index.html.twig', [
            'controller_name' => 'ConfirmSuppressionController',
        ]);
    }
}
