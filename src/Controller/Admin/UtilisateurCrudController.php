<?php

namespace App\Controller\Admin;

use App\Entity\Utilisateur;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UtilisateurCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Utilisateur::class;
    }


    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Utilisateurs')
            ->setEntityLabelInSingular('Utilisateur');
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
            ->setFormTypeOption('disabled', 'disabled'),

            ArrayField::new('roles'),

            TextField::new('nom')
            ->setFormTypeOption('disabled', 'disabled'),

            TextField::new('prenom')
            ->setFormTypeOption('disabled', 'disabled'),

            TextField::new('email')
            ->setFormTypeOption('disabled', 'disabled'),

            TextField::new('adresse')
            ->setFormTypeOption('disabled', 'disabled'),

            TextField::new('cp')
            ->setFormTypeOption('disabled', 'disabled'),

            TextField::new('ville')
            ->setFormTypeOption('disabled', 'disabled'),
            
            // TextEditorField::new('description'),
        ];
    }
}
