<?php

namespace App\Controller\Admin;

use App\Entity\CategoriesRecette;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CategoriesRecetteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CategoriesRecette::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Catégories de recettes')
            ->setEntityLabelInSingular('Catégorie de recettes')
            ->setPageTitle('index', 'Amiam - Administration des catégories de recettes')
                      ;
    }


    public function configureFields(string $pageName): iterable
    {

        yield IdField::new('id')
            ->hideOnForm()
            ->hideOnIndex()
            ->setFormTypeOption('disabled', 'disabled');
        yield TextField::new('categorie');
       
    }
}
