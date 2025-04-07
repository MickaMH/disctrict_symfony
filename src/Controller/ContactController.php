<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact', methods: ['GET', 'POST'])]
    public function contact(Request $request, MailerInterface $mailer): Response
    {
        // Gestion des requêtes GET
        if ($request->isMethod('GET')) {
            return $this->render('contact/index.html.twig'); // Retourne la vue Twig pour afficher le formulaire
        }

        // Gestion des requêtes POST
        $data = json_decode($request->getContent(), true);

        if (!$data || !isset($data['email'], $data['name'], $data['firstName'], $data['question'])) {
            return new JsonResponse(['message' => 'Données invalides ou champs manquants.'], 400);
        }

        try {
            $email = (new Email())
                ->from($data['email'])
                ->to('votre_email@example.com') // Remplacez par votre email de réception
                ->subject('Nouvelle demande de contact')
                ->html(sprintf(
                    "<p><strong>Nom :</strong> %s</p>
                    <p><strong>Prénom :</strong> %s</p>
                    <p><strong>Email :</strong> %s</p>
                    <p><strong>Adresse :</strong> %s</p>
                    <p><strong>Téléphone :</strong> %s</p>
                    <p><strong>Question :</strong> %s</p>",
                    htmlspecialchars($data['name']),
                    htmlspecialchars($data['firstName']),
                    htmlspecialchars($data['email']),
                    htmlspecialchars($data['address'] ?? 'Non fourni'),
                    htmlspecialchars($data['phone'] ?? 'Non fourni'),
                    nl2br(htmlspecialchars($data['question']))
                ));

            $mailer->send($email);

            // Retourne un message de succès au frontend
            return new JsonResponse(['message' => 'Email envoyé avec succès.'], 200);
        } catch (\Exception $e) {
            return new JsonResponse([
                'message' => 'Erreur lors de l\'envoi de l\'email.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
