<?php

namespace App\Controller;

use App\Repository\PlatRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'app_panier')]
public function index(SessionInterface $session, PlatRepository $platRepository): Response
{
    $panier = $session->get('panier', []);

    $panierWithData = [];

    foreach($panier as $id => $quantite) {
        $plat = $platRepository->find($id);
        if ($plat) {
            $image = $plat->getImage();
            $panierWithData[] = [
                'plat' => $plat,
                'quantite' => $quantite,
                'image' => $image
            ];
        } else {
            // handle the case where the plat is not found
            // you could log an error, or add a default image, etc.
        }
    }

    $total = 0;

    foreach($panierWithData as $item) {
        $totalItem = $item['plat']->getPrix() * $item['quantite'];
        $total += $totalItem;
    }

    return $this->render('panier/index.html.twig', [
        'controller_name' => 'PanierController',
        'items' => $panierWithData,
        'total' => $total
    ]);
}

#[Route('/panier/add/{id}', name: 'app_panier_add')]
public function add($id, SessionInterface $session)
{
    $panier = $session->get('panier', []);

    if(!empty($panier[$id])) {
        $panier[$id]++;
    } else {
        $panier[$id] = 1;
    }

    $session->set('panier', $panier);

    return $this->redirectToRoute('app_panier');
}


#[Route('/panier/removeOne/{id}', name: 'app_panier_removeOne')]
public function removeOne($id, SessionInterface $session)
{
    $panier = $session->get('panier', []);

    if(!empty($panier[$id])) {
        $panier[$id]--;

        if($panier[$id] == 0){
            unset($panier[$id]);
        }
    }

    $session->set('panier', $panier);

    return $this->redirectToRoute('app_panier');
}


#[Route('/panier/remove/{id}', name: 'app_panier_remove')]
public function remove($id, SessionInterface $session)
{
    $panier = $session->get('panier', []);

    if(!empty($panier[$id])) {
        unset($panier[$id]);
    }

    $session->set('panier', $panier);

    return $this->redirectToRoute('app_panier');
}
}
