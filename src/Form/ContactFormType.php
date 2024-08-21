<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;


class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

        ->add('nom', TextType::class, [
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Regex([
                    'pattern' => '/^(?!-)[a-zA-Z-]*[a-zA-Z]$/',
                    'message' => 'Le nom est incorrect',
                ]),
            ],
            'label' => '*Nom',
            'attr' => [
                
                'class' => 'form-control fs-4 border-3 bordures fond_input',
                // 'placeholder' => 'Entrez votre nom',
            ],
        ])

        ->add('prenom', TextType::class, [
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Regex([
                    'pattern' => '/^[a-zA-Z]+(?:-[a-zA-Z]+)*$/',
                    'message' => 'Le prénom est incorrect',
                ]),
            ],
            'label' => '*Prénom',
            'attr' => [
                
                'class' => 'form-control fs-4 border-3 bordures fond_input',
                // 'placeholder' => 'Entrez votre nom',
            ],
        ])

        ->add('email', EmailType::class, [
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Regex([
                    'pattern' => '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                    'message' => "L'adresse email est incorrecte",
                ]),
            ],
            'label' => '*Email',
            'attr' => [
                
                'class' => 'form-control fs-4 border-3 bordures fond_input',
                // 'placeholder' => 'Entrez votre nom',
            ],
        ])

        ->add('telephone', TextType::class, [
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Regex([
                    'pattern' => '/^[0-9]{10}$/',
                    'message' => 'Le numéro est incorrect',
                ]),
            ],
            'label' => '*Téléphone',
            'attr' => [
                
                'class' => 'form-control fs-4 border-3 bordures fond_input',
                // 'placeholder' => 'Entrez votre nom',
            ],
        ])

        ->add('demande', TextAreaType::class, [
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Regex([
                    'pattern' => '/^[^<>]{3,300}$/',
                    'message' => 'Caractères incorrects dans la demande',
                ]),
            ],
            'label' => '*Votre demande ou question',
            'attr' => [
                
                'class' => 'form-control fs-4 border-3 bordures fond_input',
                // 'placeholder' => 'Entrez votre nom',
            ],
        ])

        ->add('submit', SubmitType::class, [
            'label' => 'Envoyer',
            'attr' => [
                
                'class' => 'd-flex justify-content-center align-items-center fw-medium mx-auto shadow-lg fs-5 rounded-3 bouton_categories',
                'style' => 'width: 15rem; height: 3rem;',
                // 'placeholder' => 'Entrez votre nom',
            ],
        ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'data_class' => null, // Set to null if you don't want to bind the form to an entity
        ]);
    }
}
