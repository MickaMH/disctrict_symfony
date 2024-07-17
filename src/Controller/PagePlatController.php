<?php

namespace App\Controller;

use App\Repository\PlatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PagePlatController extends AbstractController
{
    private $platRepo;

    public function __construct(PlatRepository $platRepo)
    {
        $this->platRepo = $platRepo;
    }

    #[Route('/page/plat/{id}', name: 'app_page_plat')]
    public function show($id, Request $request): Response
    {
        // Récupère le plat avec l'ID passé en paramètre dans l'URL
        $plat = $this->platRepo->find($id);

        if (!$plat) {
            throw $this->createNotFoundException('Le plat avec l\'ID ' . $id . ' n\'existe pas');
        }

        // Affiche les données du plat
        return $this->render('page_plat/index.html.twig', [
            'plat' => $plat,
        ]);
    }
}
