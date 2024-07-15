<?php

// src/Controller/SearchController.php

namespace App\Controller;

use App\Entity\Plat;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;

class SearchController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/search', name: 'app_search')]
    public function searchAction(Request $request)
    {
        $searchQuery = $request->query->get('search');
        $plats = $this->em->getRepository(Plat::class)->findPlatsBySearchQuery($searchQuery);

        return $this->render('search/index.html.twig', array('plats' => $plats));
    }

    public function indexAction()
    {
    return $this->render('SearchController:index.html.twig');
    }
}