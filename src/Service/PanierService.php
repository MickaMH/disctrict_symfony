<?php

// src/Service/PanierService.php

namespace App\Service;

use App\Repository\PlatRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PanierService
{
    private $session;
    private $platRepository;

    public function __construct(SessionInterface $session, PlatRepository $platRepository)
    {
        $this->session = $session;
        $this->platRepository = $platRepository;
    }

    public function getPanierWithData(): array
    {
        $panier = $this->session->get('panier', []);

        $panierWithData = [];

        foreach ($panier as $id => $quantite) {
            $plat = $this->platRepository->find($id);
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

        return $panierWithData;
    }

    public function getTotal(): int
    {
        $panierWithData = $this->getPanierWithData();
        $total = 0;

        foreach ($panierWithData as $item) {
            $totalItem = $item['plat']->getPrix() * $item['quantite'];
            $total += $totalItem;
        }

        return $total;
    }

    public function add($id)
    {
        $panier = $this->session->get('panier', []);

        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }

        $this->session->set('panier', $panier);
    }

    public function removeOne($id)
    {
        $panier = $this->session->get('panier', []);

        if (!empty($panier[$id])) {
            $panier[$id]--;

            if ($panier[$id] == 0) {
                unset($panier[$id]);
            }
        }

        $this->session->set('panier', $panier);
    }

    public function remove($id)
    {
        $panier = $this->session->get('panier', []);

        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }

        $this->session->set('panier', $panier);
    }
}