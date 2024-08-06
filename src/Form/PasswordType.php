<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class PasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('ancien_password')
            // ->add('nouveau_password')
            // ->add('confirm_password')
        
            ->add('oldPassword', PasswordType::class, [
                'label' => 'Ancien mot de passe',
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\EqualTo([
                        'value' => $this->getUser()->getPassword(),
                        'message' => 'L\'ancien mot de passe est incorrect',
                    ]),
                ],
            ])
            ->add('newPassword', PasswordType::class, [
                'label' => 'Nouveau mot de passe',
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\NotEqualTo([
                        'value' => $this->getUser()->getPassword(),
                        'message' => 'Le nouveau mot de passe doit être différent de l\'ancien mot de passe',
                    ]),
                ],
            ])
            ->add('confirmNew', PasswordType::class, [
                'label' => 'Confirmer le nouveau mot de passe',
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\EqualTo([
                        'value' => $this->get('newPassword')->getData(),
                        'message' => 'Les deux mots de passe ne correspondent pas',
                    ]),
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
