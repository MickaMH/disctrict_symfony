<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\FacturationType;
use App\Form\LivraisonType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function index(Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
    $formFacturation = $this->createForm(FacturationType::class);
    $formLivraison = $this->createForm(LivraisonType::class);

    if ($request->isMethod('POST')) {
        $this->adresseFacturation($request, $entityManager, $security, $formFacturation);
        $this->adresseLivraison($request, $entityManager, $security, $formLivraison);
        return $this->redirectToRoute('app_test');
    }

    return $this->render('test/index.html.twig', [
        'controller_name' => 'TestController',
        'formFacturation' => $formFacturation,
        'formLivraison' => $formLivraison
    ]);
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
}
