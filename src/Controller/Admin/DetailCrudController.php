<?php

namespace App\Controller\Admin;

use App\Entity\Detail;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class DetailCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Detail::class;
    }


    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Details')
            ->setEntityLabelInSingular('Detail');
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
            ->setFormTypeOption('disabled', 'disabled'),

            IntegerField::new('plats_id')
            ->setFormTypeOption('disabled', 'disabled'),

            IntegerField::new('quantite')
            ->setFormTypeOption('disabled', 'disabled'),

            IntegerField::new('commande_id')
            ->setFormTypeOption('disabled', 'disabled'),
        ];
    }


    public function configureActions(Actions $actions): Actions
    {
    return $actions
        ->disable(Action::DELETE);
    }

}
