<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Commande;

class ConfirmCommandeController extends AbstractController
{
    #[Route('/confirm/commande', name: 'app_confirm_commande')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser(); // Get the connected user
        $commandes = $entityManager
            ->getRepository(Commande::class)
            ->findBy(['utilisateur' => $user]); // Retrieve commandes for the connected user

        return $this->render('confirm_commande/index.html.twig', [
            'commandes' => $commandes,
        ]);
    }
}
