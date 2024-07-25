<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Detail;

use App\Repository\PlatRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/commande', name: 'app_commande_')]
class CommandeController extends AbstractController
{
    #[Route('/ajout', name: 'add')]
    public function add(SessionInterface $session, PlatRepository $platRepository, EntityManagerInterface $em, MailerInterface $mailer): Response
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
        $commande->setUtilisateur($this->getUSER());
        $commande->setDateCommande(new \DateTime());
        $commande->setEtat('0'); // Exemple : état initial

        $totalCommande = 0; // Initialisation du prix total

        foreach ($panier as $item => $quantite) {
            $detail = new Detail();

            // Récupération du plat
            $plat = $platRepository->find($item);

            // Création du détail de commande
            $detail->setQuantite($quantite);
            $detail->setPlats($plat);
            $detail->setCommande($commande);

            // Calcul du sous-total pour ce plat
            $sousTotal = $quantite * $plat->getPrix(); // Assurez-vous que la méthode getPrix() existe dans votre entité Plat
            // Ajout au prix total de la commande
            $totalCommande += $sousTotal;

            $commande->addDetail($detail);
        }

        // Affectez le prix total à la commande
        $commande->setTotal($totalCommande);

        //On persiste et on flush
        $em->persist($commande);
        $em->flush();

        $panierWithData = $this->resumeCommande($session, $platRepository);

        // Envoyer un email à l'utilisateur avec les informations de sa commande
        $this->sendOrderConfirmationEmail($panierWithData, $mailer);

        $session->remove('panier');

        $this->addFlash('message', 'Commande créée avec succès');
        return $this->redirectToRoute('app_confirm_commande');
    }

    public function resumeCommande(SessionInterface $session, PlatRepository $platRepository): array
    {
        $panier = $session->get('panier', []);

        $panierWithData = [];

        foreach ($panier as $id => $quantite) {
            $plat = $platRepository->find($id);
            if ($plat) {
                $image = $plat->getImage();
                $panierWithData[] = [
                    'plat' => $plat,
                    'quantite' => $quantite,
                    'image' => $image
                ];
            }
        }
        
        return $panierWithData;
    }

    private function sendOrderConfirmationEmail(array $panierWithData, MailerInterface $mailer)
    {
    if ($this->getUser()) {
        $emailAddress = $this->getUser()->getUserIdentifier();
        $email = (new Email())
            ->from('TheDistrict@gmail.com') // Remplacez par votre adresse email
            ->to($emailAddress)
            ->subject('Récapitulatif de commande')
            ->html($this->renderView('order_confirmation.html.twig', [
                'panierWithData' => $panierWithData,
            ]))
            ->addPart((new DataPart(fopen('C:\xampp\htdocs\disctrict_symfony\public\images\district\logo.webp', 'r'), 'logo', 'image/webp'))->asInline());
            // ->addPart((new DataPart(fopen('C:\xampp\htdocs\disctrict_symfony\public\images\plats\image_plat_vierge.webp', 'r'), 'plat', 'image/webp'))->asInline());

        $mailer->send($email);
    }
    }
}
