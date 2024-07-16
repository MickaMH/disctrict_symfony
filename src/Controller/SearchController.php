<?php

// src/Controller/SearchController.php

namespace App\Controller;

use App\Entity\Plat;
use App\Service\SearchService;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class SearchController extends AbstractController
{
    private $searchService;
    private $entityManager;

    public function __construct(SearchService $searchService, EntityManagerInterface $entityManager)
    {
        $this->searchService = $searchService;
        $this->entityManager = $entityManager;
    }

    #[Route('/search', name: 'app_search')]
    public function searchAction(Request $request)
    {
        $searchQuery = $request->query->get('search', ''); // default to an empty string
        $plats = $this->entityManager->getRepository(Plat::class)->findAll(); // retrieve plats data from database

        $filteredPlats = $this->searchService->filterPlatsBySearchQuery($plats, $searchQuery);

        return $this->render('search/index.html.twig', array(
            'plats' => $plats,
            'search_query' => $searchQuery,
            'filtered_plats' => $filteredPlats,
        ));
    }
}