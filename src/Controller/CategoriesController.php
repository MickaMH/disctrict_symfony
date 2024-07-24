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
        $categories = $this->categorieRepo->findAll();

        return $this->render('categories/index.html.twig', [
            'controller_name' => 'CategoriesController',

            'categories' => $categories,
        ]);
    }
}
