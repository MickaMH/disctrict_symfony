<?php

// src/Controller/TestController.php

namespace App\Controller;

use App\Repository\CommandeRepository;
use App\Repository\PlatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function index(CommandeRepository $commandeRepository, PlatRepository $platRepository): Response
    {
    // Récupère l'utilisateur connecté
    $user = $this->getUser();

    // Récupère toutes les commandes de l'utilisateur connecté
    $commandes = $commandeRepository->findBy(['utilisateur' => $user]);

    // Prépare un tableau pour stocker les commandes avec leurs détails et plats
    $commandesAvecDetails = [];

    // Boucle sur chaque commande
    foreach ($commandes as $commande) {
        // Récupère les détails de la commande
        $details = $commande->getDetails();

        // Boucle sur chaque détail pour récupérer le plat associé
        foreach ($details as $detail) {
            $plat = $platRepository->find($detail->getPlats());
            $detail->setPlat($plat);
        }

        // Stocke la commande avec ses détails et plats dans le tableau
        $commandesAvecDetails[] = [
            'commande' => $commande,
            'details' => $details,
        ];
    }

    return $this->render('test/index.html.twig', [
        'controller_name' => 'TestController',
        'commandes' => $commandesAvecDetails,
    ]);
    }
}
