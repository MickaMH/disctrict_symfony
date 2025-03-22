<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoriesController extends AbstractController
{
    private $categorieRepo;

    public function __construct(CategorieRepository $categorieRepo)
    {
        $this->categorieRepo = $categorieRepo;
    }

    #[Route('/categories', name: 'app_categories')]
    public function index(): Response
    {
        // Récupération des catégories actives
        $categories = $this->categorieRepo->findBy(['active' => 1]);

        // Séparation de la catégorie avec l'ID 10 des autres catégories
        $categoryWithId9 = null;
        $otherCategories = [];

        foreach ($categories as $category) {
            if ($category->getId() === 9) {
                $categoryWithId9 = $category;
            } else {
                $otherCategories[] = $category;
            }
        }

        // Ajout de la catégorie ID 10 en dernier
        if ($categoryWithId9) {
            $otherCategories[] = $categoryWithId9;
        }

        return $this->render('categories/index.html.twig', [
            'controller_name' => 'CategoriesController',
            'categories' => $otherCategories, // Liste triée
        ]);
    }
}
