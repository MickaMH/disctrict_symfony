<?php

namespace App\Controller\Admin;

use App\Entity\Plat;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PlatCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Plat::class;
    }


    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Plats')
            ->setEntityLabelInSingular('Plat');
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
            ->setFormTypeOption('disabled', 'disabled'),

            IntegerField::new('categories_id'),

            TextField::new('libelle'),

            TextField::new('description'),

            TextField::new('prix'),

            ImageField::new('image') // Ajout de ce champ d'upload d'image
                ->setBasePath('/images/plats/') // Chemin vers le dossier d'upload
                ->setUploadDir('public/images/plats/') // Actual server directory
                ->setLabel('Image') // Libellé du champ
                ->setRequired(false),
                
            BooleanField::new('active'),
        ];
    }

}
