<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Repository\CategorieRepository;
use App\Repository\CommandeRepository;
use App\Repository\PlatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoriesController extends AbstractController
{
    private $commandeRepo;
    private $categorieRepo;
    private $platRepo;

    public function __construct(CommandeRepository $commandeRepo, CategorieRepository $categorieRepo, PlatRepository $platRepo)
    {
        $this->commandeRepo = $commandeRepo;
        $this->categorieRepo = $categorieRepo;
        $this->platRepo = $platRepo;
    }

    #[Route('/categories', name: 'app_categories')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser(); // Get the connected user
        $commandes = $entityManager
            ->getRepository(Commande::class)
            ->findBy(['utilisateur' => $user]); // Retrieve commandes for the connected user

        $categories = $this->categorieRepo->findAll();

        return $this->render('categories/index.html.twig', [
            'controller_name' => 'CategoriesController',

            'categories' => $categories,
            'commandes' => $commandes
        ]);
    }
}
