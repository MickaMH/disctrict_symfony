<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use Symfony\Component\Validator\Constraints\Image;

class CategorieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Categorie::class;
    }


    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Catégories')
            ->setEntityLabelInSingular('Catégorie');
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
            ->setFormTypeOption('disabled', 'disabled'),

            TextField::new('libelle'),

            // TextEditorField::new('description'),

            ImageField::new('image') // Ajout de ce champ d'upload d'image
                ->setBasePath('images/categories/') // Chemin vers le dossier d'upload
                ->setUploadDir('images/categories/') // Actual server directory
                ->setHelp('Formats autorisés : PNG, JPEG') // Aide pour les utilisateurs
                ->setLabel('Image') // Libellé du champ
                ->setRequired(false)
                ->setFileConstraints(new Image(
                    maxSize: '500k',
                    mimeTypes: ['image/png', 'image/jpeg'],
                    maxWidth: 1024,
                    maxHeight: 768,
                )),

            BooleanField::new('active'),
        ];
    }

}
