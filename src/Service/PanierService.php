<?php

namespace App\Service\Panier;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PanierService {

    protected $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function add(int $id) {
        $panier = $this->session->get('panier', []);

        if(!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }

        $this->session->set('panier', $panier);
    }

    public function remove(int $id) {}

   /*  public function getFullPanier() : array {}

    public function getTotal() : float {} */
}