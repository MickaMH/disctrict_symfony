<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class InfosPersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('email')
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
            ],
            ])

            ->add('adresse', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Regex([
                        'pattern' => '/^[0-9]+\s[A-Za-zÀ-ÿ ]*[A-Za-zÀ-ÿ]+[A-Za-zÀ-ÿ ]*$/i',
                        'message' => "L'adresse est incorrecte",
                    ]),
                ],
                'label' => '*Adresse',
            'attr' => [
                'class' => 'form-control fs-4 border-3 bordures fond_input',
            ],
            ])

            ->add('cp', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Regex([
                        'pattern' => '/^(?:0[1-9]|[1-8]\d|9[0-8])\d{3}$/',
                        'message' => 'Le code postal est incorrect',
                    ]),
                ],
                'label' => '*Code postal',
            'attr' => [
                'class' => 'form-control fs-4 border-3 bordures fond_input',
            ],
            ])

            ->add('ville', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Regex([
                        'pattern' => '/^[a-zA-Z][a-zA-Z\' -]{1,40}$/',
                        'message' => 'Le nom de ville est incorrect',
                    ]),
                ],
                'label' => '*Ville',
            'attr' => [
                'class' => 'form-control fs-4 border-3 bordures fond_input',
            ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
