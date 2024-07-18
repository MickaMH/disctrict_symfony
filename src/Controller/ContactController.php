<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ContactFormType;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request)
    {
        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Process the form data
            $data = $form->getData();
            // ...
        }

        // Stocker les erreurs dans une variable
        $errors = $form->getErrors(true);

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
            'errors' => $errors,
        ]);
    }
}
