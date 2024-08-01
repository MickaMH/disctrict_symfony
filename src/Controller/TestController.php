<?php

namespace App\Controller;

use App\Entity\Commande;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Routing\Attribute\Route;

class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
public function index(EntityManagerInterface $entityManager, MailerInterface $mailer): Response
{
    $lastOrder = $this->getLastOrder($entityManager);
    $plats = [];

    if ($lastOrder) {
        $commande = [
            // Récupérez les données de la commande que vous souhaitez envoyer par email
            'id' => $lastOrder->getId(),
            'date' => $lastOrder->getDateCommande(),
            // ...
        ];

        // Récupérez les détails de la commande
        $details = $lastOrder->getDetails();

        // Envoyer un email à l'utilisateur avec les informations de sa commande
        // $this->sendNewConfirmationEmail($commande, $details, $mailer);
    }

    $plats = $this->getPlatsFromDetails($details);
    dump($plats); // Add this line
    return $this->render('test/index.html.twig', [
    'commande' => $commande ?? [],
    'details' => $details ?? [],
    'plats' => $plats,
]);
}

    private function getLastOrder(EntityManagerInterface $entityManager): ?Commande
    {
        if ($this->getUser()) {
            $userId = $this->getUser()->getId();
            $lastOrder = $entityManager->getRepository(Commande::class)->findOneBy(['utilisateur' => $userId], ['id' => 'DESC']);

            return $lastOrder;
        }

        return null;
    }

    private function getPlatsFromDetails(Collection $details): array
{
    $plats = [];
    foreach ($details as $detail) {
        dump($detail); // Add this line
        $plat = $detail->getPlat();
        if ($plat) {
            dump($plat); // Add this line
            $plats[] = [
                'id' => $plat->getId(),
                'libelle' => $plat->getLibelle(),
                'prix' => $plat->getPrix(),
                'image' => $detail->getImage(),
            ];
        }
    }
    return $plats;
}

    private function sendNewConfirmationEmail(array $commande, Collection $details, MailerInterface $mailer)
    {
        if ($this->getUser()) {
            $emailAddress = $this->getUser()->getUserIdentifier();
            $email = (new Email())
                ->from('TheDistrict@gmail.com') // Remplacez par votre adresse email
                ->to($emailAddress)
                ->subject('Récapitulatif de commande')
                ->html($this->renderView('new_confirmation.html.twig', [
                    'commande' => $commande,
                    'details' => $details,
                ]))
                ->addPart((new DataPart(fopen('C:\xampp\htdocs\disctrict_symfony\public\images\district\logo.webp', 'r'), 'logo', 'image/webp'))->asInline());
            // ->addPart((new DataPart(fopen('C:\xampp\htdocs\disctrict_symfony\public\images\plats\image_plat_vierge.webp', 'r'), 'plat', 'image/webp'))->asInline());

            $mailer->send($email);
        }
    }
}