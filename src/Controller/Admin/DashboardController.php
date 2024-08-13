<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use App\Entity\Commande;
use App\Entity\Detail;
use App\Entity\Plat;
use App\Entity\Utilisateur;
use App\Repository\CommandeRepository;
use App\Repository\PlatRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DashboardController extends AbstractDashboardController
{
    private $commandeRepository;
    private $platRepository;

    private $entityManager;

    public function __construct(CommandeRepository $commandeRepository, PlatRepository $platRepository, EntityManagerInterface $entityManager)
    {
        $this->commandeRepository = $commandeRepository;
        $this->platRepository = $platRepository;

        $this->entityManager = $entityManager;
    }
    

    #[Route('/admin', name: 'admin')]
#[IsGranted('ROLE_CHEF')]
public function index(): Response
{
    // Récupère les commandes avec état 0
    $commandes = $this->commandeRepository->findBy(['etat' => 0]);

    // Récupère les commandes avec état 1
    $commandesEnCours = $this->commandeRepository->findBy(['etat' => 1]);

    // Récupère les commandes avec état 2
    $commandesTerminees = $this->commandeRepository->findBy(['etat' => 2]);

    // Récupère les commandes avec état 3
    $commandesLivrees = $this->commandeRepository->findBy(['etat' => 3]);

    // Prépare un tableau pour stocker les commandes avec leurs détails et plats
    $commandesAvecDetails = [];

    // Boucle sur chaque commande
    foreach ($commandes as $commande) {
        // Récupère les détails de la commande
        $details = $commande->getDetails();

        // Boucle sur chaque détail pour récupérer le plat associé
        foreach ($details as $detail) {
            $plat = $this->platRepository->find($detail->getPlats());
            $detail->setPlat($plat);
        }

        // Stocke la commande avec ses détails et plats dans le tableau
        $commandesAvecDetails[] = [
            'commande' => $commande,
            'details' => $details,
        ];
    }

    // Prépare un tableau pour stocker les commandes en cours avec leurs détails et plats
    $commandesEnCoursAvecDetails = [];

    // Boucle sur chaque commande en cours
    foreach ($commandesEnCours as $commande) {
        // Récupère les détails de la commande
        $details = $commande->getDetails();

        // Boucle sur chaque détail pour récupérer le plat associé
        foreach ($details as $detail) {
            $plat = $this->platRepository->find($detail->getPlats());
            $detail->setPlat($plat);
        }

        // Stocke la commande en cours avec ses détails et plats dans le tableau
        $commandesEnCoursAvecDetails[] = [
            'commande' => $commande,
            'details' => $details,
        ];
    }

    // Prépare un tableau pour stocker les commandes terminées avec leurs détails et plats
    $commandesTermineesAvecDetails = [];

    // Boucle sur chaque commande terminée
    foreach ($commandesTerminees as $commande) {
        // Récupère les détails de la commande
        $details = $commande->getDetails();

        // Boucle sur chaque détail pour récupérer le plat associé
        foreach ($details as $detail) {
            $plat = $this->platRepository->find($detail->getPlats());
            $detail->setPlat($plat);
        }

        // Stocke la commande terminée avec ses détails et plats dans le tableau
        $commandesTermineesAvecDetails[] = [
            'commande' => $commande,
            'details' => $details,
        ];
    }

    // Prépare un tableau pour stocker les commandes livrées avec leurs détails et plats
    $commandesLivreesAvecDetails = [];

    // Boucle sur chaque commande livrée
    foreach ($commandesLivrees as $commande) {
        // Récupère les détails de la commande
        $details = $commande->getDetails();

        // Boucle sur chaque détail pour récupérer le plat associé
        foreach ($details as $detail) {
            $plat = $this->platRepository->find($detail->getPlats());
            $detail->setPlat($plat);
        }

        // Stocke la commande livrée avec ses détails et plats dans le tableau
        $commandesLivreesAvecDetails[] = [
            'commande' => $commande,
            'details' => $details,
        ];
    }

    return $this->render('admin/dashboard.html.twig', [
        'controller_name' => 'DashboardController',
        'commandesAvecDetails' => $commandesAvecDetails,
        'commandesEnCoursAvecDetails' => $commandesEnCoursAvecDetails,
        'commandesTermineesAvecDetails' => $commandesTermineesAvecDetails,
        'commandesLivreesAvecDetails' => $commandesLivreesAvecDetails,
    ]);
}


    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Disctrict Symfony - Administration')
            ->renderContentMaximized();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Tableau de bord', 'fa fa-home');
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', Utilisateur::class);
        yield MenuItem::linkToCrud('Catégories', 'fas fa-table-cells-large', Categorie::class);
        yield MenuItem::linkToCrud('Plats', 'fas fa-utensils', Plat::class);
        yield MenuItem::linkToCrud('Details', 'fas fa-table-cells', Detail::class);
        yield MenuItem::linkToCrud('Commandes', 'fas fa-shopping-basket', Commande::class);
    }


    #[Route('/admin/commande/{id}/update-etat', name: 'admin_commande_update_etat')]
    #[IsGranted('ROLE_CHEF')]
    public function updateEtat(Commande $commande): Response
    {
        $etat = $commande->getEtat();
        $commande->setEtat($etat + 1);
        $this->entityManager->flush();

        return $this->redirectToRoute('admin');
    }
    
}
