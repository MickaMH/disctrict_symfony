<?php

namespace App\Controller\Admin;

use App\Entity\Plat;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Validator\Constraints\Image;

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

            // IntegerField::new('categories_id'),
            AssociationField::new('categories', 'Catégorie') // Relation avec Categorie
            ->setRequired(true), // Catégorie obligatoire

            TextField::new('libelle'),

            TextField::new('description'),

            TextField::new('prix'),

            ImageField::new('image') // Ajout de ce champ d'upload d'image
                ->setBasePath('images/plats/') // Chemin vers le dossier d'upload
                ->setUploadDir('public/images/plats/') // Actual server directory
                ->setHelp('Formats autorisés : png, jpg, jpeg, webp. Taille autorisée : 400x400 pixels max.') // Aide pour les utilisateurs
                ->setLabel('Image') // Libellé du champ
                ->setRequired(false)
                ->setFileConstraints(new Image(
                    maxSize: '500k',
                    mimeTypes: ['image/png', 'image/jpg', 'image/jpeg', 'image/webp'],
                    maxWidth: 400,
                    maxHeight: 400,
                )),
                
            BooleanField::new('active'),
        ];
    }

}
