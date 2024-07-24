<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Utilisateur;
use App\Repository\CommandeRepository;
use App\Repository\DetailRepository;
use App\Repository\PlatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CompteController extends AbstractController
{
    
    private $commandeRepo;
    private $detailRepo;
    private $platRepo;

    public function __construct(CommandeRepository $commandeRepo, DetailRepository $detailRepo, PlatRepository $platRepo)
    {
        
        $this->commandeRepo = $commandeRepo;
        $this->detailRepo = $detailRepo;
        $this->platRepo = $platRepo;
    }

    #[Route('/compte', name: 'app_compte')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser(); // Get the connected user
        $commandes = $entityManager
            ->getRepository(Commande::class)
            ->findBy(['utilisateur' => $user]); // Retrieve commandes for the connected user

        // $commandes = $this->commandeRepo->findAll();

        // $details = $this->detailRepo->findAll();
        $details = $this->detailRepo->findBy(['commande' => $commandes]);

        // $plats = $this->platRepo->findBy(['detail' => $details]);

        return $this->render('compte/index.html.twig', [
            'controller_name' => 'CompteController',

            'commandes' => $commandes,
            'details' => $details,
            // 'plats' => $plats,
        ]);
    }
}