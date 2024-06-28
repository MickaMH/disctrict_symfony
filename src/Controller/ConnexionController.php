<?php

namespace App\Controller;

use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ConnexionController extends AbstractController
{
    private $userRepo;

    public function __construct(UtilisateurRepository $userRepo){
        $this->userRepo = $userRepo;
    }

    #[Route('/connexion', name: 'app_connexion')]
    public function index(): Response
    {
        $identifiant = $this->getUser()->getUserIdentifier();
        if($identifiant){
            $info = $this->userRepo->findOneBy(["email" =>$identifiant]);
        }

        return $this->render('connexion/index.html.twig', [
            'controller_name' => 'ConnexionController',

            'informations' => $info
        ]);
    }
}
