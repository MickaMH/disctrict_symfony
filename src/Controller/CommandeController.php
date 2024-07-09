<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Detail;

use App\Repository\PlatRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/commande', name: 'app_commande_')]
class CommandeController extends AbstractController
{
    #[Route('/ajout', name: 'add')]
    public function add(SessionInterface $session, PlatRepository $platRepository, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $panier = $session->get('panier', []);

        if (empty($panier)) {
            $this->addFlash('message', 'Votre panier est vide !');
            return $this->redirectToRoute('app_accueil');
        }

        // Création de la commande
        $commande = new Commande();
        // Remplissage de la commande (à compléter avec les valeurs appropriées)
        $commande->setDateCommande(new \DateTime());
        $commande->setTotal(1); // Exemple : total à calculer
        $commande->setEtat('0'); // Exemple : état initial

        foreach ($panier as $item => $quantite) {
            $detail = new Detail();

            // Récupération du plat
            $plat = $platRepository->find($item);

            // Création du détail de commande
            $detail->setQuantite($quantite);
            $detail->setPlats($plat);
            $detail->setCommande($commande);

            $commande->addDetail($detail);
        }

        //On persiste et on flush
        $em->persist($commande);
        $em->flush();


        return $this->render('commande/index.html.twig', [
            'controller_name' => 'CommandeController',
        ]);
    }
}
