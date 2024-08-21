<?php

namespace App\Form;

use App\Entity\Commande;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\IsTrue;

class AdressesDesktopType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('adresse_facturation', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Regex([
                        'pattern' => '/^[0-9]+\s[A-Za-zÀ-ÿ ]*[A-Za-zÀ-ÿ]+[A-Za-zÀ-ÿ ]*$/i',
                        'message' => "L'adresse est incorrecte",
                    ]),
                ],
            ])

            ->add('cp_facturation', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Regex([
                        'pattern' => '/^(?:0[1-9]|[1-8]\d|9[0-8])\d{3}$/',
                        'message' => 'Le code postal est incorrect',
                    ]),
                ],
            ])

            ->add('ville_facturation', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Regex([
                        'pattern' => '/^[a-zA-Z][a-zA-Z\' -]{1,40}$/',
                        'message' => 'Le nom de ville est incorrect',
                    ]),
                ],
            ])

            ->add('adresse_livraison', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Regex([
                        'pattern' => '/^[0-9]+\s[A-Za-zÀ-ÿ ]*[A-Za-zÀ-ÿ]+[A-Za-zÀ-ÿ ]*$/i',
                        'message' => "L'adresse est incorrecte",
                    ]),
                ],
            ])

            ->add('cp_livraison', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Regex([
                        'pattern' => '/^(?:0[1-9]|[1-8]\d|9[0-8])\d{3}$/',
                        'message' => 'Le code postal est incorrect',
                    ]),
                ],
            ])

            ->add('ville_livraison', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Regex([
                        'pattern' => '/^[a-zA-Z][a-zA-Z\' -]{1,40}$/',
                        'message' => 'Le nom de ville est incorrect',
                    ]),
                ],
            ])

            // ->add('boutons_radio', ChoiceType::class, [
            //     'choices' => [
            //         'Carte bancaire' => 'option1',
            //         'Paypal' => 'option2',
            //         'Virement bancaire' => 'option3',
            //     ],
            //     'expanded' => true,
            //     'multiple' => false,
            //     'attr' => [
                
            //     'class' => '',
            //     'disabled' => true,
            // ],
            // ])

            // ->add('numero_carte', TextType::class, [
            //     'attr' => [
            //         'class' => 'col-3 fs-4 border-3 bordures fond_input rounded-3',
            //         'placeholder' => '0000 0000 0000 0000',
            //         'maxlength' => 19,
            //         'disabled' => true,
            //     ],
            // ])

            // ->add('titulaire_carte', TextType::class, [
            //     'attr' => [
            //         'class' => 'col-4 fs-4 border-3 bordures fond_input rounded-3',
            //         'placeholder' => 'Dupont Pierre',
            //         'maxlength' => 50,
            //         'disabled' => true,
            //     ],
            // ])

            // ->add('expiration_carte', TextType::class, [
            //     'attr' => [
            //         'class' => 'col-1 fs-4 border-3 bordures fond_input rounded-3',
            //         'placeholder' => '10/25',
            //         'maxlength' => 5,
            //         'disabled' => true,
            //     ],
            // ])

            // ->add('cvv_carte', TextType::class, [
            //     'attr' => [
            //         'class' => 'col-1 fs-4 border-3 bordures fond_input rounded-3',
            //         'placeholder' => '000',
            //         'maxlength' => 3,
            //         'disabled' => true,
            //     ],
            // ])

            ->add('cgu', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => "Vous êtes d'accord avec les conditions générales d'utilisation.",
                    ]),
                ],
            ])

            ->add('creation_commande', SubmitType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
