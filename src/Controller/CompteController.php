<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Detail;
use App\Entity\Utilisateur;
use App\Repository\CommandeRepository;
// use App\Repository\DetailRepository;
use App\Repository\PlatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class CompteController extends AbstractController
{
    #[Route('/compte', name: 'app_compte')]
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

    return $this->render('compte/index.html.twig', [
        'controller_name' => 'CompteController',
        'commandes' => $commandesAvecDetails,
    ]);
    }



    #[Route('/compte/modifPassword', name: 'app_compte_modifPassword')]
    public function changerMotDePasse(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $oldPassword = $request->get('old_password');
        $newPassword = $request->get('new_password');
        $confirmNewPassword = $request->get('confirm_new_password');

        // Vérifier que l'ancien mot de passe est correct
        if (!$passwordHasher->isPasswordValid($user, $oldPassword)) {
            // L'ancien mot de passe est incorrect
            $this->addFlash('error', 'Ancien mot de passe incorrect');
            return $this->redirectToRoute('app_compte');
        }

        // Vérifier que les deux nouveaux mots de passe sont identiques
        if ($newPassword !== $confirmNewPassword) {
            // Les deux nouveaux mots de passe ne sont pas identiques
            $this->addFlash('error', 'Les deux nouveaux mots de passe ne sont pas identiques');
            return $this->redirectToRoute('app_compte');
        }

        // Vérifier que le nouveau mot de passe contient au moins 6 caractères
        if (strlen($newPassword) < 6) {
        // Le nouveau mot de passe est trop court
        $this->addFlash('error', 'Le nouveau mot de passe doit contenir au moins 6 caractères');
        return $this->redirectToRoute('app_compte');
        }

        // Hasher le nouveau mot de passe
        $newPasswordHash = $passwordHasher->hashPassword($user, $newPassword);

        // Mettre à jour le mot de passe de l'utilisateur
        $user->setPassword($newPasswordHash);
        $entityManager->flush();

        // Afficher un message de confirmation
        $this->addFlash('success', 'Mot de passe mis à jour avec succès');
        return $this->redirectToRoute('app_compte');
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

        return $this->redirectToRoute('app_confirm_suppression');
    }


}