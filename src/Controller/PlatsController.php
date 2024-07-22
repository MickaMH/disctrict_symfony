<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Repository\CommandeRepository;
use App\Repository\PlatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PlatsController extends AbstractController
{
    private $commandeRepo;
    private $platRepo;

    public function __construct(CommandeRepository $commandeRepo, PlatRepository $platRepo)
    {
        $this->commandeRepo = $commandeRepo;
        $this->platRepo = $platRepo;
    }

    #[Route('/plats', name: 'app_plats')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser(); // Get the connected user
        $commandes = $entityManager
            ->getRepository(Commande::class)
            ->findBy(['utilisateur' => $user]); // Retrieve commandes for the connected user

        $plats = $this->platRepo->findAll();

        return $this->render('plats/index.html.twig', [
            'controller_name' => 'PlatsController',

            'plats' => $plats,
            'commandes' => $commandes
        ]);
    }
}
