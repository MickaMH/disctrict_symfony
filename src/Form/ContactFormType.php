<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
        ])

        ->add('prenom', TextType::class, [
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Regex([
                    'pattern' => '/^[a-zA-Z]+(?:-[a-zA-Z]+)*$/',
                    'message' => 'Le prénom est incorrect',
                ]),
            ],
        ])

        ->add('email', EmailType::class, [
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Regex([
                    'pattern' => '/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/',
                    'message' => "L'adresse email est incorrecte",
                ]),
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
        ])

        ->add('demande', TextAreaType::class, [
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Regex([
                    'pattern' => '/^[a-zA-Z0-9\s\.,:\-!?]+$/',
                    'message' => 'Caractères incorrects dans la demande',
                ]),
            ],
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'data_class' => null, // Set to null if you don't want to bind the form to an entity
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'validation_groups' => ['Default'],
        ]);
    }
}
