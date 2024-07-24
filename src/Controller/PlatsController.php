<?php

namespace App\Controller;

use App\Repository\PlatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PlatsController extends AbstractController
{
    private $platRepo;

    public function __construct(PlatRepository $platRepo)
    {
        $this->platRepo = $platRepo;
    }

    #[Route('/plats', name: 'app_plats')]
    public function index(): Response
    {
        $plats = $this->platRepo->findAll();

        return $this->render('plats/index.html.twig', [
            'controller_name' => 'PlatsController',

            'plats' => $plats,
        ]);
    }
}
