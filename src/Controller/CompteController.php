<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Detail;
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

    #[Route('/compte/supprimer', name: 'app_compte_supprimer')]
public function supprimerCompte(EntityManagerInterface $entityManager): Response
{
    $user = $this->getUser(); // Get the connected user
    if (!$user instanceof Utilisateur) {
        throw new \Exception('Vous devez être connecté pour supprimer votre compte');
    }

    // Delete the Detail entities associated with the Commande entities
    $commandes = $entityManager
        ->getRepository(Commande::class)
        ->findBy(['utilisateur' => $user]);
    foreach ($commandes as $commande) {
        $details = $entityManager
            ->getRepository(Detail::class)
            ->findBy(['commande' => $commande]);
        foreach ($details as $detail) {
            $entityManager->remove($detail);
        }
        $entityManager->remove($commande);
    }

    // Delete the User entity
    $entityManager->remove($user);
    $entityManager->flush();

    // Déconnexion de l'utilisateur
    $this->container->get('security.token_storage')->setToken(null);

    return $this->redirectToRoute('app_confirm_suppression'); // Redirection vers la page d'accueil
}
}