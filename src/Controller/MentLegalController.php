<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MentLegalController extends AbstractController
{
    #[Route('/ment/legal', name: 'app_ment_legal')]
    public function index(): Response
    {
        return $this->render('ment_legal/index.html.twig', [
            'controller_name' => 'MentLegalController',
        ]);
    }
}
