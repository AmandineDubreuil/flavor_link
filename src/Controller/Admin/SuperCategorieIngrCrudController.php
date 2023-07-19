<?php

namespace App\Controller\Admin;

use App\Entity\SuperCategorieIngr;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SuperCategorieIngrCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SuperCategorieIngr::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Super Catégories')
            ->setEntityLabelInSingular('Super Catégorie')
            ->setPageTitle('index', 'Amiam - Administration des Super Catégories d\'ingrédients');
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
            ->hideOnForm()
            ->setFormTypeOption('disabled', 'disabled'),
            TextField::new('superCategorie'),
            
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
