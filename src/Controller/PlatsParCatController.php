<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\PlatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PlatsParCatController extends AbstractController
{
    private $categorieRepo;
    private $platRepo;

    public function __construct(CategorieRepository $categorieRepo, PlatRepository $platRepo)
    {
        $this->categorieRepo = $categorieRepo;
        $this->platRepo = $platRepo;
    }

    #[Route('/plats/par/cat', name: 'app_plats_par_cat')]
    public function show(Request $request): Response
    {
        $id = $request->query->get('id'); // Récupère la valeur du paramètre 'id' depuis l'URL

        // Maintenant, vous pouvez utiliser $id dans votre logique métier
        // Par exemple, recherchez la catégorie avec cet identifiant
        $categorie = $this->categorieRepo->find($id);

        // Ensuite, récupérez les plats associés à cette catégorie
        $plats = $this->platRepo->findBy(['categories' => $categorie]);

        return $this->render('plats_par_cat/index.html.twig', [
            'id' => $id,
            'plats' => $plats,
            'categorie' => $categorie,
        ]);
    }
}
