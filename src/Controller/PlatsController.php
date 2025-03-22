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
        // Récupérer tous les plats actifs
        $plats = $this->platRepo->findBy(['active' => 1], ['categories' => 'ASC']);

        // Séparer les plats avec categories_id = 9 des autres
        $platsWithCategoryId9 = [];
        $otherPlats = [];

        foreach ($plats as $plat) {
            if ($plat->getCategories()->getId() === 9) {
                $platsWithCategoryId9[] = $plat;
            } else {
                $otherPlats[] = $plat;
            }
        }

        // Réorganiser la liste : plats classiques suivis des plats avec categories_id = 9
        $sortedPlats = array_merge($otherPlats, $platsWithCategoryId9);

        return $this->render('plats/index.html.twig', [
            'controller_name' => 'PlatsController',
            'plats' => $sortedPlats, // Liste triée
        ]);
    }
}
