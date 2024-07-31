<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;

class FacturationMobileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            // ->add('adresse_facturation', TextareaType::class, [
            //     'label' => 'Adresse facturation',
            //     'required' => false
            //     ]
            // )

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

            ->add('modifier_facturation_mobile', SubmitType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
