<?php

namespace App\Controller;

use App\Form\FacturationMobileType;
use App\Form\FacturationType;
use App\Form\LivraisonMobileType;
use App\Form\LivraisonType;
use App\Repository\PlatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

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

        $formFacturation = $this->createForm(FacturationType::class);
        $formFacturationMobile = $this->createForm(FacturationMobileType::class);

        $formLivraison = $this->createForm(LivraisonType::class);
        $formLivraisonMobile = $this->createForm(LivraisonMobileType::class);

        if ($request->isMethod('POST')) {

            $this->adresseFacturation($request, $entityManager, $security, $formFacturation);
            $this->adresseFacturationMobile($request, $entityManager, $security, $formFacturationMobile);

            $this->adresseLivraison($request, $entityManager, $security, $formLivraison);
            $this->adresseLivraisonMobile($request, $entityManager, $security, $formLivraisonMobile);

            // Ajouter un message flash pour informer l'utilisateur
            $this->addFlash('success', "L'adresse a bien été mise à jour.");

            return $this->redirectToRoute('app_resume_commande');
        }

        return $this->render('resume_commande/index.html.twig', [
            'controller_name' => 'ResumeCommandeController',

            'panierWithData' => $panierWithData,

            'formFacturation' => $formFacturation,
            'formFacturationMobile' => $formFacturationMobile,

            'formLivraison' => $formLivraison,
            'formLivraisonMobile' => $formLivraisonMobile
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

    public function adresseFacturation(Request $request, EntityManagerInterface $entityManager, Security $security, FormInterface $formFacturation): void
    {
    $formFacturation->handleRequest($request);

    if ($formFacturation->isSubmitted() && $formFacturation->isValid()) {
        // Traitement des données du formulaire de facturation
        $dataFacturation = $formFacturation->getData();

        // Met à jour l'adresse de facturation de l'utilisateur
        $utilisateur = $security->getUser();
        $adresseFacturation = $dataFacturation->getAdresseFacturation();
        $utilisateur->setAdresseFacturation($adresseFacturation);

        $cpFacturation = $dataFacturation->getCpFacturation();
        $utilisateur->setCpFacturation($cpFacturation);

        $villeFacturation = $dataFacturation->getVilleFacturation();
        $utilisateur->setVilleFacturation($villeFacturation);

        $entityManager->flush();
        }
    }

    public function adresseFacturationMobile(Request $request, EntityManagerInterface $entityManager, Security $security, FormInterface $formFacturationMobile): void
    {
    $formFacturationMobile->handleRequest($request);

    if ($formFacturationMobile->isSubmitted() && $formFacturationMobile->isValid()) {
        // Traitement des données du formulaire de facturation
        $dataFacturationMobile = $formFacturationMobile->getData();

        // Met à jour l'adresse de facturation de l'utilisateur
        $utilisateur = $security->getUser();
        $adresseFacturationMobile = $dataFacturationMobile->getAdresseFacturation();
        $utilisateur->setAdresseFacturation($adresseFacturationMobile);

        $cpFacturationMobile = $dataFacturationMobile->getCpFacturation();
        $utilisateur->setCpFacturation($cpFacturationMobile);

        $villeFacturationMobile = $dataFacturationMobile->getVilleFacturation();
        $utilisateur->setVilleFacturation($villeFacturationMobile);

        $entityManager->flush();
        }
    }

    public function adresseLivraison(Request $request, EntityManagerInterface $entityManager, Security $security, FormInterface $formLivraison): void
    {
    $formLivraison->handleRequest($request);

    if ($formLivraison->isSubmitted() && $formLivraison->isValid()) {
        // Traitement des données du formulaire de livraison
        $dataLivraison = $formLivraison->getData();

        // Met à jour l'adresse de livraison de l'utilisateur
        $utilisateur = $security->getUser();
        $adresseLivraison = $dataLivraison->getAdresseLivraison();
        $utilisateur->setAdresseLivraison($adresseLivraison);

        $cpLivraison = $dataLivraison->getCpLivraison();
        $utilisateur->setCpLivraison($cpLivraison);

        $villeLivraison = $dataLivraison->getVilleLivraison();
        $utilisateur->setVilleLivraison($villeLivraison);

        $entityManager->flush();
        }
    }

    public function adresseLivraisonMobile(Request $request, EntityManagerInterface $entityManager, Security $security, FormInterface $formLivraisonMobile): void
    {
    $formLivraisonMobile->handleRequest($request);

    if ($formLivraisonMobile->isSubmitted() && $formLivraisonMobile->isValid()) {
        // Traitement des données du formulaire de facturation
        $dataLivraisonMobile = $formLivraisonMobile->getData();

        // Met à jour l'adresse de facturation de l'utilisateur
        $utilisateur = $security->getUser();
        $adresseLivraisonMobile = $dataLivraisonMobile->getAdresseLivraison();
        $utilisateur->setAdresseLivraison($adresseLivraisonMobile);

        $cpLivraisonMobile = $dataLivraisonMobile->getCpLivraison();
        $utilisateur->setCpLivraison($cpLivraisonMobile);

        $villeLivraisonMobile = $dataLivraisonMobile->getVilleLivraison();
        $utilisateur->setVilleLivraison($villeLivraisonMobile);

        $entityManager->flush();
        }
    }
}