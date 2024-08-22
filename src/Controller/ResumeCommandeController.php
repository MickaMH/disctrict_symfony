<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Detail;
use App\Form\AdressesDesktopType;
use App\Repository\PlatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class ResumeCommandeController extends AbstractController

{
    #[Route('/resume/commande', name: 'app_resume_commande')]
    public function index(SessionInterface $session, PlatRepository $platRepository, Request $request, EntityManagerInterface $entityManager, Security $security): Response
    
    {
        $panier = $session->get('panier', []);

    if (empty($panier)) {
        $this->addFlash('message', 'Votre panier est vide !');
        return $this->redirectToRoute('app_panier');
    } else {
        $this->denyAccessUnlessGranted('ROLE_USER');
    }

    $panierWithData = $this->resumeCommande($session, $platRepository);

    $formAdressesDesktop = $this->createForm(AdressesDesktopType::class);

    $formAdressesDesktop->handleRequest($request);

    if ($formAdressesDesktop->isSubmitted() && $formAdressesDesktop->isValid()) {
        $dataFacturation = $formAdressesDesktop->getData();

        $commande = new Commande();

        $adresseFacturation = $dataFacturation->getAdresseFacturation();
        $commande->setAdresseFacturation($adresseFacturation);

        $cpFacturation = $dataFacturation->getCpFacturation();
        $commande->setCpFacturation($cpFacturation);

        $villeFacturation = $dataFacturation->getVilleFacturation();
        $commande->setVilleFacturation($villeFacturation);

        $adresseLivraison = $dataFacturation->getAdresseLivraison();
        $commande->setAdresseLivraison($adresseLivraison);

        $cpLivraison = $dataFacturation->getCpLivraison();
        $commande->setCpLivraison($cpLivraison);

        $villeLivraison = $dataFacturation->getVilleLivraison();
        $commande->setVilleLivraison($villeLivraison);

        $commande->setUtilisateur($this->getUser());
        $commande->setDateCommande(new \DateTime());
        $commande->setEtat('0');

        $totalCommande = 0;

        foreach ($panier as $item => $quantite) {
            $detail = new Detail();

            $plat = $platRepository->find($item);

            $detail->setQuantite($quantite);
            $detail->setPlats($plat);
            $detail->setCommande($commande);

            $sousTotal = $quantite * $plat->getPrix();
            $totalCommande += $sousTotal;

            $commande->addDetail($detail);
        }

        $commande->setTotal($totalCommande);

        $entityManager->persist($commande);
        $entityManager->flush();

        $session->remove('panier');

        // $this->addFlash('message', 'Commande créée avec succès');
        return $this->redirectToRoute('app_confirm_commande');
    }

    return $this->render('resume_commande/index.html.twig', [
        'controller_name' => 'ResumeCommandeController',
        'panierWithData' => $panierWithData,
        'formAdressesDesktop' => $formAdressesDesktop,
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