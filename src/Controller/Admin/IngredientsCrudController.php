<?php

namespace App\Controller\Admin;

use App\Entity\CategoriesIngr;
use App\Entity\Ingredients;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class IngredientsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Ingredients::class;
    }
    public function createEntity(string $entityFqcn)
    {
        $ingredient = new Ingredients();
        $ingredient->setUser($this->getUser());

        return $ingredient;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Ingrédients')
            ->setEntityLabelInSingular('Ingrédient')
            ->setPageTitle('index', 'Amiam - Administration des ingrédients');
    }


    public function configureFields(string $pageName): iterable
    {

            yield IdField::new('id')
            ->hideOnForm()
            ->setFormTypeOption('disabled', 'disabled');
            yield TextField::new('ingredient');
            yield AssociationField::new('categorie');
            yield AssociationField::new('user')
            ->hideOnForm()
            
            ;
          
                           
 

    //     return [
    //         IdField::new('id')
    //         ->hideOnForm()
    //         ->setFormTypeOption('disabled', 'disabled'),
    //         TextField::new('ingredient'),
    //         AssociationField::new('categorie'),
    //         AssociationField::new('user')
    //         ->setFormTypeOption('disabled', 'disabled'),
    //         AssociationField::class
                           
    // ];
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
