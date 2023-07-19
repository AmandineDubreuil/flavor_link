<?php

namespace App\Controller\Admin;

use App\Entity\CategoriesIngr;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CategoriesIngrCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CategoriesIngr::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Catégories')
            ->setEntityLabelInSingular('Catégorie')
            ->setPageTitle('index', 'Amiam - Administration des Catégories d\'ingrédients');
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
            ->hideOnForm()
            ->setFormTypeOption('disabled', 'disabled'),
            TextField::new('categorie'),
            AssociationField::new('superCategorieIngr')

            // TextEditorField::new('description'),
        ];
    }
    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
