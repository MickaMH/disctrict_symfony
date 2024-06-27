<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\PlatRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoriesController extends AbstractController
{
    private $categorieRepo;
    private $platRepo;

    public function __construct(CategorieRepository $categorieRepo, PlatRepository $platRepo)
    {
        $this->categorieRepo = $categorieRepo;
        $this->platRepo = $platRepo;
    }

    #[Route('/categories', name: 'app_categories')]
    public function index(): Response
    {
        $categories = $this->categorieRepo->findAll();

        return $this->render('categories/index.html.twig', [
            'controller_name' => 'CategoriesController',

            'categories' => $categories
        ]);
    }
}
