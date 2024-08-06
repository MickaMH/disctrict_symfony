<?php

namespace App\Controller;

use App\Form\InfosPersType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ModifInfosController extends AbstractController
{
    private $entityManager;

    public function __construct(ManagerRegistry $registry)
    {
        $this->entityManager = $registry->getManager();
    }

    #[Route('/modif/infos', name: 'app_modif_infos')]
    public function index(Request $request): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(InfosPersType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Mettre à jour les informations de l'utilisateur
            $this->entityManager->flush();

            // Ajouter un message flash pour informer l'utilisateur
            $this->addFlash('success', 'Vos informations ont bien été mises à jour.');

            // Rediriger l'utilisateur vers la page de profil
            return $this->redirectToRoute('app_compte');
        }

        return $this->render('modif_infos/index.html.twig', [
            'modifInfosForm' => $form->createView(),
        ]);
    }
}
