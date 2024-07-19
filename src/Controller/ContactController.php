<?php

namespace App\Controller;

use App\Form\ContactFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;


class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            $nom = $data['nom'];
            $prenom = $data['prenom'];
            $mailUser = $data['email'];
            $telephone = $data['telephone'];
            $demande = $data['demande'];
            
            $email = (new Email())
            ->from($mailUser)
            ->to('admin@admin.com')
            ->subject('Demande ou question')
            ->html(
                '<h1>Demande ou question</h1>'.
                '<p>Nom : ' . $nom . '</p>' .
                '<p>Prénom : ' . $prenom . '</p>' .
                '<p>Adresse email : ' . $mailUser . '</p>' .
                '<p>Téléphone : ' . $telephone . '</p>' .
                '<p>Demande : ' . $demande . '</p>'
            );

            $mailer->send($email);

            return $this->redirectToRoute('app_confirm_demande');
        }

        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'contactForm' => $form
        ]);
    }
}
