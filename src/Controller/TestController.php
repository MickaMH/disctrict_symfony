<?php

// src/Controller/TestController.php

namespace App\Controller;

use App\Repository\CommandeRepository;
use App\Repository\PlatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Part\DataPart;

class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function index(CommandeRepository $commandeRepository, PlatRepository $platRepository, MailerInterface $mailer): Response
    {
        // Récupère l'utilisateur connecté
        $user = $this->getUser();

        // Récupère la dernière commande de l'utilisateur connecté
        $lastCommande = $commandeRepository->findOneBy(['utilisateur' => $user], ['id' => 'DESC']);

        // Récupère les détails de la commande
        $details = $lastCommande->getDetails();

        // Récupère les plats associés à chaque détail de commande
        foreach ($details as $detail) {
            $plat = $platRepository->find($detail->getPlats());
            $detail->setPlat($plat);
        }

        // Crée un email
        $email = (new Email())
        ->from('expediteur@example.com')
        ->to($user->getEmail())
        ->subject('Confirmation de commande')
        ->html($this->renderView('new_confirmation.html.twig', [
            'app' => [
                'user' => $user,
                ],
            'last_commande' => $lastCommande,
            'details' => $details,
        ]))

        ->addPart((new DataPart(fopen('C:\xampp\htdocs\disctrict_symfony\public\images\district\logo.webp', 'r'), 'logo', 'image/webp'))->asInline());

        foreach ($details as $detail) {
        $imagePath = 'C:\xampp\htdocs\disctrict_symfony\public\images\plats\\' . $detail->getPlat()->getImage();
        $email->addPart((new DataPart(fopen($imagePath, 'r'), 'plat', 'image/webp'))->asInline());
        }

        // Envoie l'email
        $mailer->send($email);

        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
            'last_commande' => $lastCommande,
            'details' => $details,
        ]);
    }
}
