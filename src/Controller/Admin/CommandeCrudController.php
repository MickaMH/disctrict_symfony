<?php

namespace App\Controller\Admin;

use App\Entity\Commande;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Intl\DateTime;

class CommandeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Commande::class;
    }


    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Commandes')
            ->setEntityLabelInSingular('Commande');
    }



    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
            ->setFormTypeOption('disabled', 'disabled'),

            DateField::new('date_commande')
            ->setFormTypeOption('disabled', 'disabled')
            ->setFormat('dd/MM/yyyy'),

            TextField::new('total')
            ->setFormTypeOption('disabled', 'disabled'),

            ChoiceField::new('etat')
            ->setChoices([
            'Enregistrée' => 0,
            'En préparation' => 1,
            'En livraison' => 2,
            'Livrée' => 3,
            ]),

            TextField::new('adresse_facturation')
            ->setFormTypeOption('disabled', 'disabled'),

            TextField::new('cp_facturation')
            ->setFormTypeOption('disabled', 'disabled'),

            TextField::new('ville_facturation')
            ->setFormTypeOption('disabled', 'disabled'),

            TextField::new('adresse_livraison')
            ->setFormTypeOption('disabled', 'disabled'),

            TextField::new('cp_livraison')
            ->setFormTypeOption('disabled', 'disabled'),

            TextField::new('ville_livraison')
            ->setFormTypeOption('disabled', 'disabled'),
        ];
    }


    public function configureActions(Actions $actions): Actions
    {
    return $actions
        ->disable(Action::DELETE);
    }

}
