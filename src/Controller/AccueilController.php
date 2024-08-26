<?php

namespace App\Controller;

use App\Repository\DetailRepository;
use App\Repository\PlatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(DetailRepository $detailRepository, PlatRepository $platRepository): Response
    {
        $top3Plats = $this->getTop3Plats($detailRepository);
        $top3Categories = $this->getTop3Categories($detailRepository, $platRepository);

        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'top3Plats' => $top3Plats,
            'top3Categories' => $top3Categories,
        ]);
    }

    private function getTop3Plats(DetailRepository $detailRepository): array
    {
        // Récupère les détails triés par quantité décroissante
        $details = $detailRepository->findBy([], ['quantite' => 'DESC']);

        // Prépare un tableau pour stocker les plats avec leur quantité totale
        $platsAvecQuantite = [];

        // Boucle sur chaque détail
        foreach ($details as $detail) {
            $plat = $detail->getPlats();
            if (isset($platsAvecQuantite[$plat->getId()])) {
                $platsAvecQuantite[$plat->getId()]['quantite'] += $detail->getQuantite();
            } else {
                $platsAvecQuantite[$plat->getId()] = [
                    'plat' => $plat, // Pass the entire Plat object
                    'quantite' => $detail->getQuantite(),
                ];
            }
        }

        // Trie les plats par quantité décroissante
        uasort($platsAvecQuantite, function($a, $b) {
            return $b['quantite'] <=> $a['quantite'];
        });

        // Extrait les 3 premiers éléments du tableau
        $top3Plats = array_slice($platsAvecQuantite, 0, 3);

        return $top3Plats;
    }

    private function getTop3Categories(DetailRepository $detailRepository, PlatRepository $platRepository): array
    {
        // Récupère les détails triés par quantité décroissante
        $details = $detailRepository->findBy([], ['quantite' => 'DESC']);

        // Prépare un tableau pour stocker les catégories avec leur quantité totale
        $categoriesAvecQuantite = [];

        // Boucle sur chaque détail
        foreach ($details as $detail) {
            $plat = $detail->getPlats();
            $categorie = $plat->getCategories();
            if (isset($categoriesAvecQuantite[$categorie->getId()])) {
                $categoriesAvecQuantite[$categorie->getId()]['quantite'] += $detail->getQuantite();
            } else {
                $categoriesAvecQuantite[$categorie->getId()] = [
                    'categorie' => $categorie, // Pass the entire Categorie object
                    'quantite' => $detail->getQuantite(),
                ];
            }
        }

        // Trie les catégories par quantité décroissante
        uasort($categoriesAvecQuantite, function($a, $b) {
            return $b['quantite'] <=> $a['quantite'];
        });

        // Extrait les 3 premiers éléments du tableau
        $top3Categories = array_slice($categoriesAvecQuantite, 0, 3);

        return $top3Categories;
    }
}