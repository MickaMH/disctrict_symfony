<?php

namespace App\Controller;

use App\Repository\PlatRepository;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ResumeCommandeController extends AbstractController
{
    #[Route('/resume/commande', name: 'app_resume_commande')]
    public function index(SessionInterface $session, PlatRepository $platRepository, MailerInterface $mailer): Response
    {
        $panier = $session->get('panier', []);

        if (empty($panier)) {
            $this->addFlash('message', 'Votre panier est vide !');
            return $this->redirectToRoute('app_panier');
        } else {
            $this->denyAccessUnlessGranted('ROLE_USER');
        }

        $panierWithData = $this->resumeCommande($session, $platRepository);

        return $this->render('resume_commande/index.html.twig', [
            'controller_name' => 'ResumeCommandeController',
            'panierWithData' => $panierWithData,
        ]);
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
}