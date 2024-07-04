<?php

// src/Service/PanierService.php

namespace App\Service;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PanierService
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function add($item)
    {
        $panier = $this->session->get('panier', []);
        $panier[] = $item;
        $this->session->set('panier', $panier);
    }

    public function remove($item)
    {
        $panier = $this->session->get('panier', []);
        $key = array_search($item, $panier);
        if ($key !== false) {
            unset($panier[$key]);
        }
        $this->session->set('panier', $panier);
    }

    public function list()
    {
        return $this->session->get('panier', []);
    }
}

